<?php

namespace App\Http\Controllers\reseller;

use App\Models\Baner;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;


class MerchantResellerController extends Controller
{
    /**
     * Menampilkan profil toko beserta data terkait.
     * Mengambil data merchant, banner, dan notifikasi untuk ditampilkan pada halaman upload profil store.
     */
    public function showProfilStore()
    {
        $user = Auth::user();
        $merchant = Merchant::where('user_id', $user->id)->first();
        $baners = Baner::all();
        $readyBaner = Baner::where('user_id', $user->id)->first();

        return view('vendor.upload_merchant', [
            'Title' => 'Upload Profil Store',
            'Data' => $merchant,
            'Baners' => $baners,
            'Ready' => $readyBaner,
            'Notifications' => NotificationController::notifReseller(),
        ]);
    }

    /**
     * Mengunggah profil store baru.
     * Memvalidasi input, mengunggah file baner dan profil, serta menyimpan data ke dalam tabel Merchant.
     */
    public function uploadProfilStore(Request $request)
    {
        $validatedData = $this->validateMerchantData($request);

        // Proses upload file baner dan profil
        $validatedData['baner'] = $this->handleFileUpload($request->file('baner'), 'img/baner');
        $validatedData['profil'] = $this->handleFileUpload($request->file('profil'), 'img/profil');

        Merchant::create($validatedData);

        return back()->with('success', 'Success Upload Profil Store!');
    }

    /**
     * Mengedit profil store yang sudah ada.
     * Memvalidasi input, menghapus file lama, mengunggah file baru, dan memperbarui data di tabel Merchant.
     */
    public function editProfilStore(Merchant $merchant, Request $request)
    {
        $validatedData = $this->validateMerchantData($request);

        // Hapus file lama sebelum mengunggah yang baru
        $this->deleteOldFiles($merchant);

        // Proses upload file baru baner dan profil
        $validatedData['baner'] = $this->handleFileUpload($request->file('baner'), 'img/baner');
        $validatedData['profil'] = $this->handleFileUpload($request->file('profil'), 'img/profil');

        $merchant->update($validatedData);

        return back()->with('success', 'Success Update Profil Store!');
    }





    /**
     * Memvalidasi data input dari request.
     * Memastikan semua data yang diperlukan sesuai dengan aturan validasi.
     */
    private function validateMerchantData(Request $request)
    {
        return $request->validate([
            'name' => 'required|min:5|max:40',
            'baner' => 'required|image|mimes:jpg,jpeg,png|file|max:1024',
            'profil' => 'required|image|mimes:jpg,jpeg,png|file|max:1024',
            'user_id' => 'required|exists:users,id',
        ]);
    }


    /**
     * Mengunggah file ke lokasi yang ditentukan dan mengembalikan nama file yang baru.
     * Membuat nama file unik menggunakan UUID untuk mencegah duplikasi.
     */
    private function handleFileUpload($file, $destinationPath)
    {
        $path = public_path($destinationPath);
        $fileName = 'merchant' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $fileName);

        return $fileName;
    }


    /**
     * Menghapus file lama yang tersimpan di server jika file tersebut ada.
     * Digunakan sebelum mengunggah file baru agar tidak ada file yang menumpuk.
     */
    private function deleteOldFiles(Merchant $merchant)
    {
        $oldBanerPath = public_path('img/baner/' . $merchant->baner);
        $oldProfilPath = public_path('img/profil/' . $merchant->profil);

        if (File::exists($oldBanerPath)) {
            File::delete($oldBanerPath);
        }

        if (File::exists($oldProfilPath)) {
            File::delete($oldProfilPath);
        }
    }
}
