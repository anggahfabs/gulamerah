<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(12)->withQueryString();
        $counts = [
            'total' => Inquiry::count(),
            'baru' => Inquiry::where('status', 'baru')->count(),
            'diproses' => Inquiry::where('status', 'diproses')->count(),
            'selesai' => Inquiry::where('status', 'selesai')->count(),
            'arsip' => Inquiry::where('status', 'arsip')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai,arsip',
            'admin_notes' => 'nullable|string',
        ]);

        $inquiry->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $inquiry->admin_notes,
        ]);

        return back()->with('success', 'Status pesan penawaran berhasil diubah menjadi: ' . ucfirst($request->status));
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Pesan penawaran berhasil dihapus.');
    }
}
