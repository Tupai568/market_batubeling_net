<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


class PostAdminController extends Controller
{
    public function updatePasswordAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'old' => 'required',
            'password' => 'required|min:5|max:255',
            'confirm' => 'required|same:password',
        ], [
            'confirm.same' => 'Password tidak sama',
        ]);

        // Mendapatkan pengguna yang sedang login
        $user = User::findOrFail(Auth::user()->id);

        // Cek apakah password lama benar
        if (!Hash::check($request->old, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok');
        }

        // Hash password baru
        $hashedPassword = Hash::make($request->password);

        // Update password pengguna
        $user->update([
            'password' => $hashedPassword
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }


    public function verified(Request $request)
    {
        // Ambil produk berdasarkan ID
        $produk = Produk::find($request->id);

        // Periksa apakah produk ditemukan
        if (!$produk) {
            return back()->with('error', 'Data Tidak Ditemukan');
        }

        // Membalikkan status verified produk
        $produk->verified = !$produk->verified;
        $produk->save(); // Simpan perubahan ke database

        // Kembalikan respons sukses
        return back()->with('success', 'Status Produk Berhasil Diubah');
    }


    public function change(Request $request)
    {

        // Ambil pengguna berdasarkan ID
        $user = User::find($request->id);

        // Periksa apakah pengguna ada
        if (!$user) {
            return back()->with('error', 'User not found');
        }

        // Perbarui status pengguna
        /*Membalikkan Status: 
        !$user->status membalikkan status saat ini dari pengguna. 
        Jika status awal false, maka menjadi true, dan sebaliknya.*/

        $newStatus = !$user->status;
        $user->status = $newStatus;
        $user->user_type = "reseller";
        $user->save();

        // Kembalikan respons sesuai status baru
        if ($newStatus) {
            return back()->with('success', 'User berhasil verified');
        } else {
            return back()->with('error', 'User status set to pending');
        }
    }


    public function membership(Request $request)
    {
        $request->validate([
            "id" => "required|exists:users,id",
            "membership" => "required|in:basic,store,agent,mall"
        ]);

        // Ambil pengguna berdasarkan ID
        $user = User::find($request->id);

        // Update membership
        $user->membership = $request->membership;
        $user->save();

        // Tentukan jumlah produk yang diizinkan berdasarkan membership
        $status = 0;

        switch ($request->membership) {
            case 'basic':
                $status = 5;
                break;
            case 'store':
                $status = 25;
                break;
            case 'agent':
                $status = 50;
                break;
            case 'mall':
                $status = 10000;
                break;
        }

        // Ambil produk pengguna
        $products = Produk::where('user_id', $user->id)->get();
        $count = 0;

        // Update status produk
        foreach ($products as $product) {
            if ($count < $status) {
                $product->verified = 1; // Produk tidak pending
            } else {
                $product->verified = 0; // Produk menjadi pending
            }
            $product->save();
            $count++;
        }


        return back()->with('success', 'Membership Update ' . $request->membership);
    }


    public function revisi(Request $request)
    {

        $validate = $request->validate([
            "produk_id" => "required",
            "user_id" => "required",
            "message" => "required",
            "tujuan" => "required"
        ]);

        $cek =  Produk::findOrFail($request->produk_id);
        $user =  User::findOrFail($request->user_id);

        if (!$cek) {
            return back()->with('error', 'Data Tidak Ditemukan');
        }

        if (!$user) {
            return back()->with('error', 'Data Tidak Ditemukan');
        }

        $cek->revisi = 1;
        $cek->save();

        //kirim notif revisi ke user
        Notification::create($validate);

        return back()->with('success', 'Success Mengirim Revisi');
    }

    //delete data user
    public function destroyUser(Request $request)
    {
        // Ambil datauser berdasarkan ID
        $data = DataUser::find($request->id);

        // Ambil pengguna berdasarkan ID
        $user = User::find($request->user);

        // Periksa apakah pengguna ada
        if (!$data && !$user) {
            return back()->with('error', 'data not found');
        }

        /* Mengecek Apakah status user true atau tidak,
            Jika status user true maka ubah status nya */
        if ((bool) $user->status == true) {
            $newStatus = !$user->status;
            $user->status = $newStatus;
            $user->save();
        }

        $filePath = public_path('img/ktp/' . $data->image);


        // Periksa apakah file ada
        if (File::exists($filePath)) {
            // Hapus file
            File::delete($filePath);
        }

        $dataNotification = [
            "message" => "Data Anda Ditolak Karna Tidak Sesuai Persaratan, Upload Ulang Data KTP Anda Di <a href='/Setting'>Setting</a>",
            "user_id" => $data->user_id,
            "action" => "data"
        ];

        Notification::create($dataNotification);
        // Hapus data
        $data->delete();

        // Kembalikan respons yang sesuai
        return redirect("/Admin")->with('success', 'Data successfully deleted');
    }

    //delete product user
    public function deleteProduct(Request $request)
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
