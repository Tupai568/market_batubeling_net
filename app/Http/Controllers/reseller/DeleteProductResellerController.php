<?php

namespace App\Http\Controllers\Reseller;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class DeleteProductResellerController extends Controller
{
    /**
     * Menghapus produk dan berkas terkait.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id' => 'required|exists:produks,id',
        ]);

        // Ambil produk beserta relasi gambar dan notifikasi
        $produk = Produk::with(['image', 'notifications'])->findOrFail($validated['id']);

        // Hapus gambar notifikasi jika ada
        $this->deleteNotificationImages($produk);

        // Hapus berkas gambar produk
        $this->deleteFilesFromJson('img/produk/', $produk->image);

        // Hapus data dari database
        // $produk->image?->delete(); // Pastikan relasi 'image' ada
        $produk->delete();

        return back()->with('warning', 'Success Menghapus Product');
    }

    /**
     * Menghapus gambar terkait notifikasi.
     *
     * @param Produk $produk
     */
    private function deleteNotificationImages(Produk $produk)
    {
        if ($produk->notifications->isNotEmpty()) {
            foreach ($produk->notifications as $notification) {
                // Hapus file jika gambar notifikasi ada
                if (!is_null($notification->image)) {
                    $this->deleteFileIfExists('img/promo/' . $notification->image);
                }
            }
        }
    }

    /**
     * Menghapus file jika ada.
     *
     * @param string $filePath
     */
    private function deleteFileIfExists(string $filePath)
    {
        $fullPath = public_path($filePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    /**
     * Menghapus beberapa file dari JSON array.
     *
     * @param string $directory
     * @param string $json
     */
    private function deleteFilesFromJson(string $directory, string $json)
    {
        $files = json_decode($json, true) ?: [];
        foreach ($files as $file) {
            $this->deleteFileIfExists($directory . $file);
        }
    }
}
