<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Subscriber;
use App\Models\Article;
use App\Models\Certification;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'products_active' => Product::where('is_active', true)->count(),
            'inquiries_count' => Inquiry::count(),
            'inquiries_new' => Inquiry::where('status', 'baru')->count(),
            'subscribers_count' => Subscriber::count(),
            'articles_count' => Article::count(),
            'certifications_count' => Certification::count(),
            'galleries_count' => Gallery::count(),
        ];

        $recentInquiries = Inquiry::latest()->take(5)->get();
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentProducts'));
    }
}
