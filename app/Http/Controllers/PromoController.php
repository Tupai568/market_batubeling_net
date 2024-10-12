<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Unggulan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Menambah data produk yang ingin ikut promo.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'image' => 'required|image|file|max:1024',
            'user_id' => 'required|exists:users,id',
            'produk_id' => 'required|exists:produks,id',
            'tujuan' => 'required|in:admin,reseller',
        ]);

        // Ambil produk terkait
        $produk = Produk::findOrFail($validatedData['produk_id']);

        // Cek kondisi produk
        if ($produk->revisi == 1) {
            return back()->with('error', 'Produk Anda Belum Direvisi');
        }

        if ($produk->verified == 0) {
            return back()->with('error', 'Mohon Tunggu Produk Anda Di Verifikasi');
        }

        // Cek apakah produk sudah terdaftar sebagai unggulan
        if (Unggulan::where('produk_id', $validatedData['produk_id'])->exists()) {
            return back()->with('error', 'Produk Sudah Terdaftar Unggulan');
        }

        // Cek apakah ada notifikasi yang sedang dalam tinjauan
        if (Notification::where('produk_id', $validatedData['produk_id'])
            ->where('tujuan', 'admin')->exists()
        ) {
            return back()->with('error', 'Mohon Ditinggu Pembayaran Anda Sedang Ditinjau');
        }

        // Upload gambar promo
        $fileName = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('img/promo'), $fileName);
        $validatedData['image'] = $fileName;
        $validatedData['message'] = 'Mendaftarkan Produk Unggulan';

        // Simpan notifikasi
        Notification::create($validatedData);

        return back()->with('warning', 'Data Anda Akan Ditinjau 1x24Jam');
    }
}
