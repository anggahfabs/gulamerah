<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Certification;
use App\Models\Gallery;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Homepage with Hero, Audience Switcher, Bento Catalog, Volume Calculator, and Agro-Factory Story
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $categories = Category::where('is_active', true)->withCount('products')->get();
        
        $featuredProducts = Product::where('is_active', true)
            ->with(['category', 'variants' => fn($q) => $q->where('is_active', true), 'priceTiers', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $services = Service::where('is_active', true)->take(3)->get();
        $certifications = Certification::where('is_active', true)->get();
        $galleries = Gallery::where('is_active', true)->take(6)->get();
        $articles = Article::where('is_published', true)->latest()->take(3)->get();

        return view('public.home', compact(
            'settings',
            'categories',
            'featuredProducts',
            'services',
            'certifications',
            'galleries',
            'articles'
        ));
    }

    /**
     * Dedicated Product Catalog with Realtime Filter
     */
    public function products(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $categories = Category::where('is_active', true)->get();

        $query = Product::where('is_active', true)
            ->with(['category', 'variants' => fn($q) => $q->where('is_active', true), 'priceTiers', 'images']);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('raw_material', 'like', "%{$search}%");
            });
        }

        if ($request->filled('raw_material')) {
            $query->where('raw_material', $request->raw_material);
        }

        if ($request->filled('product_form')) {
            $query->where('product_form', $request->product_form);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('public.products.index', compact('products', 'categories', 'settings'));
    }

    /**
     * Product Detail with Lab Specs, COA Snippet, and Dual CTA (B2C WA / B2B RFQ)
     */
    public function productDetail($slug)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'variants' => fn($q) => $q->where('is_active', true), 'priceTiers', 'images'])
            ->firstOrFail();

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with(['category', 'variants', 'priceTiers'])
            ->take(3)
            ->get();

        return view('public.products.show', compact('product', 'relatedProducts', 'settings'));
    }

    /**
     * B2B Supply & OEM Maklon Services Page
     */
    public function services()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $services = Service::where('is_active', true)->get();

        return view('public.services.index', compact('services', 'settings'));
    }

    /**
     * Quality Standards, Lab Tests, and Certifications
     */
    public function certifications()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $certifications = Certification::where('is_active', true)->get();

        return view('public.certifications.index', compact('certifications', 'settings'));
    }

    /**
     * Factory & Plantation Visual Galleries
     */
    public function galleries(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $query = Gallery::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $galleries = $query->latest()->paginate(12)->withQueryString();

        return view('public.galleries.index', compact('galleries', 'settings'));
    }

    /**
     * Educational Articles & Industry Insights
     */
    public function articles(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $query = Article::where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $articles = $query->latest()->paginate(9)->withQueryString();

        return view('public.articles.index', compact('articles', 'settings'));
    }

    /**
     * Article Detail Reading Page
     */
    public function articleDetail($slug)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        $article->increment('views_count');

        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.articles.show', compact('article', 'relatedArticles', 'settings'));
    }

    /**
     * Contact, Factory Location, & RFQ Form
     */
    public function contact()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('public.contact', compact('settings'));
    }

    /**
     * Dual Action B2B RFQ Submission (Database + WhatsApp Redirect)
     */
    public function submitRfq(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:50',
            'email' => 'nullable|email|max:100',
            'inquiry_type' => 'required|string|max:100',
            'product_interest' => 'nullable|string|max:255',
            'estimated_volume' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:2000',
        ]);

        $validated['status'] = 'baru';
        $inquiry = Inquiry::create($validated);

        // Sales WhatsApp Destination
        $salesPhone = Setting::get('whatsapp_sales', '6281234567890');
        $cleanPhone = preg_replace('/[^0-9]/', '', $salesPhone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        // Pre-formatted Professional Quotation WhatsApp Message
        $rfqCode = '#RFQ-' . str_pad($inquiry->id, 4, '0', STR_PAD_LEFT);
        $company = $inquiry->company_name ? " [{$inquiry->company_name}]" : '';
        $product = $inquiry->product_interest ?: 'Gula Aren / Produk Pabrik';
        $volume = $inquiry->estimated_volume ?: 'Akan didiskusikan';

        $waText = "Halo Tim Sales Pabrik Gula Gumer,\n\n"
            . "Saya *{$inquiry->full_name}*{$company} ingin mengajukan permintaan penawaran pasokan / sampel (*{$rfqCode}*):\n\n"
            . "• *Tipe Inquiry*: {$inquiry->inquiry_type}\n"
            . "• *Produk Diminati*: {$product}\n"
            . "• *Estimasi Kebutuhan*: {$volume}\n"
            . "• *Catatan / Kebutuhan Khusus*: " . ($inquiry->message ?: '-') . "\n\n"
            . "Mohon informasi ketersediaan stok, lembar COA hasil lab Sucofindo, dan penawaran harga terbaik. Terima kasih.";

        $waUrl = 'https://wa.me/' . $cleanPhone . '?text=' . urlencode($waText);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'rfq_code' => $rfqCode,
                'redirect_url' => $waUrl,
                'message' => "Permintaan penawaran {$rfqCode} berhasil dikirim! Menghubungkan ke WhatsApp Sales..."
            ]);
        }

        return redirect()->away($waUrl);
    }

    /**
     * Newsletter Subscriber Handler
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
        ]);

        $sub = Subscriber::firstOrCreate(
            ['email' => strtolower($request->email)],
            ['is_active' => true]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih telah berlangganan info ketersediaan pasokan & komoditas Gumer!'
            ]);
        }

        return back()->with('success', 'Email Anda berhasil terdaftar untuk menerima pembaruan berkala dari Pabrik Gumer.');
    }
}
