<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductPriceTier;
use App\Models\Service;
use App\Models\Certification;
use App\Models\Gallery;
use App\Models\Article;
use App\Models\Inquiry;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gumer.id'],
            [
                'name' => 'Super Admin Gumer',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Settings Website
        $settings = [
            'site_name' => 'Gumer — Pabrik Gula Merah & Aren Nusantara',
            'site_tagline' => 'Produsen & Supplier Gula Murni Terpercaya Skala Industri & Retail',
            'whatsapp_sales' => '081234567890',
            'whatsapp_cs' => '081234567891',
            'email_sales' => 'sales@gumer.id',
            'factory_address' => 'Kawasan Industri Agro Enau No. 88, Cilacap, Jawa Tengah',
            'warehouse_address' => 'Pergudangan Marunda Center Blok B-12, Jakarta Utara',
            'operating_hours' => 'Senin - Jumat: 08.00 - 17.00 WIB | Sabtu: 08.00 - 14.00 WIB',
            'hero_headline' => 'Produsen & Supplier Gula Aren & Kelapa Skala Industri',
            'hero_subtitle' => 'Menyuplai kebutuhan bahan baku pangan, pabrik F&B, coffee shop, serta eceran premium langsung dari pengolahan nira murni berstandar uji lab Sucofindo & Halal.',
            'hero_badge' => 'Kapasitas Pasokan 50+ Ton / Bulan',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Categories
        $categories = [
            [
                'name' => 'Gula Semut Aren (Granulated)',
                'slug' => 'gula-semut-aren',
                'description' => 'Gula aren butiran kristal halus dengan kadar air rendah ≤ 1.2%, mudah larut dan aroma karamel pekat.',
            ],
            [
                'name' => 'Gula Aren Cetak (Enau Murni)',
                'slug' => 'gula-aren-cetak',
                'description' => 'Gula aren balok tradisional cetak batok alami, diolah murni tanpa campuran sulfit atau gula rafinasi.',
            ],
            [
                'name' => 'Gula Aren Cair (Liquid Sugar)',
                'slug' => 'gula-aren-cair',
                'description' => 'Gula nira aren cair konsentrasi tinggi 75° Brix, stabil tidak mengkristal, pilihan utama cafe & barista.',
            ],
            [
                'name' => 'Gula Kelapa Cetak (Coconut Sugar)',
                'slug' => 'gula-kelapa-cetak',
                'description' => 'Gula kelapa asli bahan baku utama industri kecap, biskuit, dan olahan bumbu masakan tradisional.',
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::create($cat);
        }

        // 4. Products, Variants & Price Tiers
        // Product 1: Gula Semut Aren Kristal
        $p1 = Product::create([
            'category_id' => $categoryModels['gula-semut-aren']->id,
            'name' => 'Gula Semut Aren Kristal Ekspor',
            'slug' => 'gula-semut-aren-kristal-ekspor',
            'raw_material' => 'Nira Pohon Aren (Arenga Pinnata) 100% Murni',
            'product_form' => 'Semut / Granule',
            'short_description' => 'Gula aren kristal premium dengan proses pengeringan modern rotary oven, menghasilkan kadar air ultra rendah dan daya larut instan.',
            'full_description' => 'Gumer Gula Semut Aren diproduksi dari nira aren segar pilihan yang disadap di perkebunan binaan di lereng pegunungan. Menggunakan proses pemasakan terkontrol suhu dan pengayakan bertingkat (mesh 16–18), produk ini menghasilkan kristal gula berwarna cokelat keemasan yang seragam. Bebas dari bahan pengawet, bebas sulfit, dan telah teruji laboratorium bersertifikasi Halal serta Sucofindo.',
            'moisture_content' => '≤ 1.2% (Standar SNI & Ekspor)',
            'mesh_size' => 'Mesh 16 - 18 (Halus Seragam)',
            'brix_content' => 'N/A (Bentuk Kering)',
            'shelf_life' => '24 Bulan dalam kemasan tertutup',
            'storage_instruction' => 'Simpan pada suhu ruang kering (20-25°C), hindari paparan kelembapan dan sinar matahari langsung.',
            'recommendations' => 'Industri Minuman Bubuk, Coffee Shop & Barista, Roti & Pastry, Herbal, Ekspor Komoditas.',
            'thumbnail' => null,
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductVariant::create(['product_id' => $p1->id, 'packaging_name' => 'Standing Pouch Zipper 250g', 'packaging_type' => 'Retail', 'unit_weight_kg' => 0.25, 'retail_price' => 16000]);
        ProductVariant::create(['product_id' => $p1->id, 'packaging_name' => 'Standing Pouch Zipper 500g', 'packaging_type' => 'Retail', 'unit_weight_kg' => 0.50, 'retail_price' => 28000]);
        ProductVariant::create(['product_id' => $p1->id, 'packaging_name' => 'Standing Pouch Zipper 1kg', 'packaging_type' => 'Retail', 'unit_weight_kg' => 1.00, 'retail_price' => 52000]);
        ProductVariant::create(['product_id' => $p1->id, 'packaging_name' => 'Karung Zak 25kg + Double Inner PE Food Grade', 'packaging_type' => 'Bulk', 'unit_weight_kg' => 25.00, 'retail_price' => 875000]);

        ProductPriceTier::create(['product_id' => $p1->id, 'min_quantity_kg' => 100, 'max_quantity_kg' => 500, 'price_per_kg' => 38000, 'note' => 'Kemasan sak 25kg, MOQ 100kg']);
        ProductPriceTier::create(['product_id' => $p1->id, 'min_quantity_kg' => 501, 'max_quantity_kg' => 2000, 'price_per_kg' => 35000, 'note' => 'Free pallet & wrapping']);
        ProductPriceTier::create(['product_id' => $p1->id, 'min_quantity_kg' => 2001, 'max_quantity_kg' => null, 'price_per_kg' => 32500, 'note' => 'Harga tonase kontrak rutin bulanan']);

        // Product 2: Gula Aren Cetak Batok
        $p2 = Product::create([
            'category_id' => $categoryModels['gula-aren-cetak']->id,
            'name' => 'Gula Aren Cetak Batok Tradisional Murni',
            'slug' => 'gula-aren-cetak-batok-tradisional-murni',
            'raw_material' => 'Nira Aren Asli Pilihan',
            'product_form' => 'Cetak / Balok',
            'short_description' => 'Gula aren cetak batok murni bertekstur padat renyah, wangi khas aren tua alami, tanpa pengeras kimia atau campuran gula rafinasi.',
            'full_description' => 'Diolah dengan metode pemasakan kuali tembaga tradisional yang menjaga kemurnian rasa manis gurih dan aroma harum khas aren. Sangat cocok untuk olahan saus gula merah, sirup dawet/cendol, jenang, dan pembuatan bumbu kecap manis kualitas super.',
            'moisture_content' => '≤ 4.5%',
            'mesh_size' => 'N/A (Bentuk Balok)',
            'brix_content' => 'N/A',
            'shelf_life' => '18 Bulan',
            'storage_instruction' => 'Simpan dalam wadah kedap udara atau tempat sejuk berventilasi baik.',
            'recommendations' => 'Industri Kecap Manis, Pabrik Biskuit, Kuliner Tradisional, Hotel & Catering.',
            'thumbnail' => null,
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductVariant::create(['product_id' => $p2->id, 'packaging_name' => 'Kemasan Daun Alami Ikat 1kg', 'packaging_type' => 'Retail', 'unit_weight_kg' => 1.0, 'retail_price' => 36000]);
        ProductVariant::create(['product_id' => $p2->id, 'packaging_name' => 'Karton Box Tebal 10kg', 'packaging_type' => 'Retail', 'unit_weight_kg' => 10.0, 'retail_price' => 330000]);
        ProductVariant::create(['product_id' => $p2->id, 'packaging_name' => 'Karung Bal 25kg (Industri)', 'packaging_type' => 'Bulk', 'unit_weight_kg' => 25.0, 'retail_price' => 700000]);

        ProductPriceTier::create(['product_id' => $p2->id, 'min_quantity_kg' => 100, 'max_quantity_kg' => 500, 'price_per_kg' => 29000, 'note' => 'Kemasan bal 25kg']);
        ProductPriceTier::create(['product_id' => $p2->id, 'min_quantity_kg' => 501, 'max_quantity_kg' => 2000, 'price_per_kg' => 26500, 'note' => 'Diskon suplai berkala']);
        ProductPriceTier::create(['product_id' => $p2->id, 'min_quantity_kg' => 2001, 'max_quantity_kg' => null, 'price_per_kg' => 24000, 'note' => 'Kontrak tonase pasokan pabrik']);

        // Product 3: Gula Aren Cair
        $p3 = Product::create([
            'category_id' => $categoryModels['gula-aren-cair']->id,
            'name' => 'Gula Aren Cair 75° Brix (Barista & Cafe Grade)',
            'slug' => 'gula-aren-cair-barista-grade',
            'raw_material' => 'Nira Aren Murni + Filterisasi Mikro',
            'product_form' => 'Cair / Liquid',
            'short_description' => 'Sirup gula aren murni dengan konsentrasi tinggi 75° Brix, tekstur kental stabil, tidak mudah basi atau mengendap.',
            'full_description' => 'Diformulasikan khusus untuk kebutuhan industri F&B kekinian, chain coffee shop, dan restoran. Dengan tingkat brix yang konsisten pada 74-75°, sirup ini memberikan rasa manis alami yang lembut tanpa menutupi cita rasa kopi asli. Telah dipasteurisasi untuk menjamin higienitas maksimal.',
            'moisture_content' => '25% (Kadar Air Terkontrol)',
            'mesh_size' => 'Micro-Filtered (Bebas Ampas)',
            'brix_content' => '74° - 75° Brix (Super Kental)',
            'shelf_life' => '12 Bulan pada suhu ruang',
            'storage_instruction' => 'Tutup rapat setelah digunakan. Simpan di tempat sejuk, tidak perlu kulkas selama segel bersih.',
            'recommendations' => 'Kopi Susu Gula Aren, Boba & Milk Tea, Topping Dessert, Rantai Minuman Kekinian.',
            'thumbnail' => null,
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductVariant::create(['product_id' => $p3->id, 'packaging_name' => 'Botol 1 Liter (Pourer Friendly)', 'packaging_type' => 'Retail', 'unit_weight_kg' => 1.3, 'retail_price' => 42000]);
        ProductVariant::create(['product_id' => $p3->id, 'packaging_name' => 'Jerigen Food Grade 5 Liter', 'packaging_type' => 'Bulk', 'unit_weight_kg' => 6.5, 'retail_price' => 185000]);
        ProductVariant::create(['product_id' => $p3->id, 'packaging_name' => 'Jerigen Food Grade 25 Liter', 'packaging_type' => 'Bulk', 'unit_weight_kg' => 32.5, 'retail_price' => 850000]);

        ProductPriceTier::create(['product_id' => $p3->id, 'min_quantity_kg' => 50, 'max_quantity_kg' => 200, 'price_per_kg' => 34000, 'note' => 'Kemasan jerigen 5L']);
        ProductPriceTier::create(['product_id' => $p3->id, 'min_quantity_kg' => 201, 'max_quantity_kg' => 1000, 'price_per_kg' => 30500, 'note' => 'Harga franchise / horeca']);
        ProductPriceTier::create(['product_id' => $p3->id, 'min_quantity_kg' => 1001, 'max_quantity_kg' => null, 'price_per_kg' => 27500, 'note' => 'Suplai rutin tonase liter pabrik']);

        // Product 4: Gula Kelapa Cetak
        $p4 = Product::create([
            'category_id' => $categoryModels['gula-kelapa-cetak']->id,
            'name' => 'Gula Kelapa Cetak Asli Grade A',
            'slug' => 'gula-kelapa-cetak-asli-grade-a',
            'raw_material' => 'Nira Pohon Kelapa Segar',
            'product_form' => 'Cetak / Balok',
            'short_description' => 'Gula kelapa cetak alami dengan rasa manis gurih khas, tekstur padat, ideal untuk industri kecap dan olahan bumbu.',
            'full_description' => 'Diproduksi dari sentra perkebunan kelapa pesisir Jawa yang terkenal menghasilkan nira dengan kadar sukrosa tinggi dan rasa gurih yang kaya. Menjadi andalan para produsen kecap manis dan biskuit terkemuka di tanah air.',
            'moisture_content' => '≤ 5.0%',
            'mesh_size' => 'N/A',
            'brix_content' => 'N/A',
            'shelf_life' => '18 Bulan',
            'storage_instruction' => 'Simpan di ruangan berventilasi baik, terhindar dari air dan kelembapan.',
            'recommendations' => 'Pabrik Kecap, Gudang Distributor Sembako, Industri Bumbu Rempah.',
            'thumbnail' => null,
            'is_active' => true,
            'is_featured' => false,
        ]);

        ProductVariant::create(['product_id' => $p4->id, 'packaging_name' => 'Kemasan Roll Plastik 1kg', 'packaging_type' => 'Retail', 'unit_weight_kg' => 1.0, 'retail_price' => 24000]);
        ProductVariant::create(['product_id' => $p4->id, 'packaging_name' => 'Karung Karpet 25kg (Industri)', 'packaging_type' => 'Bulk', 'unit_weight_kg' => 25.0, 'retail_price' => 450000]);

        ProductPriceTier::create(['product_id' => $p4->id, 'min_quantity_kg' => 100, 'max_quantity_kg' => 500, 'price_per_kg' => 19500, 'note' => 'MOQ 100kg balok']);
        ProductPriceTier::create(['product_id' => $p4->id, 'min_quantity_kg' => 501, 'max_quantity_kg' => 2000, 'price_per_kg' => 17800, 'note' => 'Pengiriman armada truk pabrik']);
        ProductPriceTier::create(['product_id' => $p4->id, 'min_quantity_kg' => 2001, 'max_quantity_kg' => null, 'price_per_kg' => 16200, 'note' => 'Kontrak tonase rutin']);

        // 5. Certifications
        Certification::create([
            'name' => 'Sertifikat Halal Resmi BPJPH',
            'issuer' => 'Badan Penyelenggara Jaminan Produk Halal (BPJPH Kemenag RI)',
            'cert_number' => 'ID3311000189280924',
            'valid_until' => 'Berlaku Selamanya (Terverifikasi Berkala)',
            'description' => 'Seluruh lini produksi gula aren dan kelapa Gumer telah memenuhi kriteria Sistem Jaminan Produk Halal (SJPH).',
            'badge_image' => null,
            'document_file' => null,
            'is_active' => true,
        ]);

        Certification::create([
            'name' => 'Izin Edar BPOM RI & Dinas Kesehatan P-IRT',
            'issuer' => 'BPOM RI & Dinkes Kab. Cilacap',
            'cert_number' => 'P-IRT No. 2073301010342-26',
            'valid_until' => '2029',
            'description' => 'Fasilitas produksi higienis telah lolos inspeksi keamanan pangan dan sanitasi dinas kesehatan.',
            'badge_image' => null,
            'document_file' => null,
            'is_active' => true,
        ]);

        Certification::create([
            'name' => 'Sertifikat Hasil Uji Laboratorium Sucofindo',
            'issuer' => 'PT Sucofindo (Persero) Lab Sentral',
            'cert_number' => 'COA-SUCO-2024-09881',
            'valid_until' => 'Uji Batch Berkala 2026',
            'description' => 'Teruji bebas residu pengawet natrium metabisulfit, bebas pewarna sintetis, dan bebas kontaminasi logam berat berbahaya.',
            'badge_image' => null,
            'document_file' => null,
            'is_active' => true,
        ]);

        Certification::create([
            'name' => 'Sertifikasi Pertanian Organik Indonesia',
            'issuer' => 'Lembaga Sertifikasi Organik (LeSOS)',
            'cert_number' => '082-LS-001-IDN-2024',
            'valid_until' => '2027',
            'description' => 'Nira disadap dari pohon aren liar alami tanpa pupuk kimia dan pestisida sintetis.',
            'badge_image' => null,
            'document_file' => null,
            'is_active' => true,
        ]);

        // 6. Services (Layanan B2B & Maklon)
        Service::create([
            'title' => 'Kontrak Pasokan Rutin Industri F&B',
            'slug' => 'kontrak-pasokan-industri',
            'subtitle' => 'Jaminan kestabilan pasokan tonase bulanan dan harga kontrak terikat',
            'description' => 'Kami melayani pabrik kecap, biskuit, roti, sirup, dan pabrik minuman yang membutuhkan pasokan gula aren dan kelapa hingga puluhan ton per bulan dengan spesifikasi teknis (kadar air & kehalusan) yang disesuaikan dengan standar QC pabrik Anda.',
            'icon_name' => 'factory',
            'badge_text' => 'Kapasitas 50+ Ton / Bulan',
            'features' => [
                'Jadwal pengiriman terjadwal armada truk/kontainer',
                'Certificate of Analysis (COA) per batch pengiriman',
                'Harga kontrak volume jangka panjang yang stabil',
                'Garansi retur bila spesifikasi tidak sesuai standar PO',
            ],
            'is_active' => true,
        ]);

        Service::create([
            'title' => 'Jasa Maklon & OEM Private Label',
            'slug' => 'jasa-maklon-private-label',
            'subtitle' => 'Miliki brand gula aren kemasan Anda sendiri tanpa perlu membangun pabrik',
            'description' => 'Solusi lengkap bagi pemilik brand, distributor, atau eksportir yang ingin menjual gula semut dan gula aren cair dengan merk dan desain kemasan sendiri. Kami mengurus produksi, kemasan food-grade berijin, hingga siap dipasarkan.',
            'icon_name' => 'package-check',
            'badge_text' => 'MOQ Mulai 500 Kg',
            'features' => [
                'Pilihan kemasan: Standing pouch zipper, jar, sachet stik, botol, jerigen',
                'Fasilitas bantuan cetak kemasan rotogravure & stiker',
                'Dukungan kelengkapan dokumen legalitas dan nomor izin',
                'Standar kualitas ekspor ke pasar global',
            ],
            'is_active' => true,
        ]);

        Service::create([
            'title' => 'Suplai Rutin Chain Coffee Shop & Horeca',
            'slug' => 'suplai-horeca-coffee-shop',
            'subtitle' => 'Gula aren cair & sachet gula semut untuk jaringan kafe dan restoran',
            'description' => 'Suplai konsisten gula aren cair 75° Brix barista grade dalam kemasan botol 1L dan jerigen 5L. Aroma smoky karamel alami yang memperkaya racikan kopi susu kekinian tanpa endapan.',
            'icon_name' => 'coffee',
            'badge_text' => 'Pilihan 100+ Coffee Shop',
            'features' => [
                'Konsistensi kekentalan brix terjamin di setiap pengiriman',
                'Pengiriman cepat ke seluruh kota besar',
                'Tersedia sachet 5g & 8g untuk sajian meja tamu hotel',
                'Free sample uji coba resep barista untuk mitra baru',
            ],
            'is_active' => true,
        ]);

        // 7. Galleries
        $galleries = [
            ['title' => 'Penderesan Nira Alami di Kebun Aren Binaan', 'category' => 'Kebun & Penderes', 'caption' => 'Penyadapan nira segar dilakukan setiap pagi hari dari pohon aren pegunungan alami.'],
            ['title' => 'Penyaringan & Pemasakan Kuali Tradisional Higienis', 'category' => 'Fasilitas Pabrik', 'caption' => 'Penguapan nira dengan kontrol api dan penyaringan bertahap untuk menjaga aroma karamel murni.'],
            ['title' => 'Mesin Rotary Dryer Pengeringan Gula Semut', 'category' => 'Fasilitas Pabrik', 'caption' => 'Pengurangan kadar air hingga di bawah 1.2% menggunakan oven rotary modern stainless steel 304.'],
            ['title' => 'Pengayakan Bergetar (Vibrating Screen Mesh 18)', 'category' => 'Laboratorium QC', 'caption' => 'Memastikan ukuran butiran gula semut seragam dan bersih dari partikel kasar.'],
            ['title' => 'Ruang Pengemasan Cleanroom Steril', 'category' => 'Fasilitas Pabrik', 'caption' => 'Packing menggunakan baju pelindung dan ruangan berstandar food safety hygiene.'],
            ['title' => 'Gudang Penyimpanan Pallet & Armada Siap Muat', 'category' => 'Pengiriman & Armada', 'caption' => 'Penataan karung sak 25kg di atas pallet kayu steril siap didistribusikan ke seluruh Indonesia.'],
        ];

        foreach ($galleries as $g) {
            Gallery::create([
                'title' => $g['title'],
                'category' => $g['category'],
                'caption' => $g['caption'],
                'image_path' => 'placeholders/gallery.jpg',
                'is_active' => true,
            ]);
        }

        // 8. Articles
        Article::create([
            'user_id' => $admin->id,
            'title' => 'Ciri-Ciri Gula Aren Asli Murni vs Gula Campuran Kimia: Panduan Bagi Industri F&B',
            'slug' => 'ciri-gula-aren-asli-murni-vs-campuran-kimia',
            'category' => 'Edukasi Kualitas',
            'excerpt' => 'Kenali perbedaan fisik, aroma, dan daya larut gula aren murni agar bahan baku produk makanan Anda aman dan berkualitas prima.',
            'content' => '<p>Bagi industri makanan dan minuman, kualitas bahan baku adalah penentu utama kepuasan konsumen. Salah satu tantangan terbesar bagi purchasing manager adalah maraknya peredaran gula aren yang telah dicampur gula pasir rafinasi atau bahan kimia pengeras sulfit.</p><p>Gula aren murni memiliki aroma karamel yang dalam dan khas, bertekstur lebih renyah ketika digigit, dan jika dilarutkan tidak meninggalkan ampas pasir atau rasa getir kimia di pangkal lidah. Di pabrik Gumer, setiap tetes nira dipastikan berasal dari petani binaan tanpa bahan kimia pengawet.</p>',
            'cover_image' => 'placeholders/article-1.jpg',
            'author_name' => 'Tim Riset & QC Gumer',
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);

        Article::create([
            'user_id' => $admin->id,
            'title' => 'Mengapa Standar Mesh 18 Gula Semut Menjadi Kunci Sukses Industri Bakery & Kopi',
            'slug' => 'standar-mesh-18-gula-semut-industri-bakery-kopi',
            'category' => 'Standar Mutu',
            'excerpt' => 'Penjelasan teknis ukuran kehalusan mesh gula semut terhadap homogenitas adonan roti dan kecepatan larut pada espresso dingin.',
            'content' => '<p>Ukuran partikel (mesh) pada gula semut bukan sekadar angka. Mesh 16–18 adalah sweet spot yang memungkinkan gula semut cepat larut dalam cairan dengan suhu ruangan tanpa perlu diaduk berlebihan, sekaligus memberikan tekstur remah (crumb) yang sempurna pada adonan kue dan biskuit.</p><p>Kadar air yang dijaga di bawah 1.5% juga memastikan gula semut tidak menggumpal saat disimpan di gudang penyimpanan hingga berbulan-bulan.</p>',
            'cover_image' => 'placeholders/article-2.jpg',
            'author_name' => 'Agus Priyono, S.T. (Kepala Produksi Gumer)',
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);

        // 9. Sample Inquiries
        Inquiry::create([
            'full_name' => 'Bambang Sudarsono',
            'company_name' => 'PT Rasa Pangan Nusantara',
            'phone_number' => '081388992211',
            'email' => 'purchasing@rasapangan.co.id',
            'inquiry_type' => 'B2B Pasokan Rutin',
            'product_interest' => 'Gula Semut Aren Kristal Ekspor',
            'estimated_volume' => '2 Ton / Bulan',
            'message' => 'Kami membutuhkan pasokan rutin gula semut aren mesh 18 untuk pabrik biskuit kami di Tangerang. Mohon dikirimkan Certificate of Analysis (COA) dan penawaran harga resmi.',
            'status' => 'baru',
        ]);
    }
}
