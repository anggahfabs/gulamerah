<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')->with('success', 'Email subscriber berhasil dihapus.');
    }

    public function exportCsv()
    {
        $subscribers = Subscriber::where('is_active', true)->get(['email', 'created_at']);
        $csvFileName = 'gumer-subscribers-' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Tanggal Berlangganan']);
            foreach ($subscribers as $sub) {
                fputcsv($file, [$sub->email, $sub->created_at->format('Y-m-d H:i:s')]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
