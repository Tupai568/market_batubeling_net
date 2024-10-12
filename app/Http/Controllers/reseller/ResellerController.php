<?php

namespace App\Http\Controllers\reseller;

use App\Models\Like;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Unggulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;

class ResellerController extends Controller
{

    /**
     * Menampilkan daftar produk milik reseller.
     * Mengambil produk berdasarkan user yang sedang login dan menghitung status produk.
     */
    public function index()
    {
        $userId = Auth::user();
        $products = $this->getUserProducts($userId->id);
        $likes = Like::where('user_id', $userId->id)->pluck('produk_id');
        $favorits = Produk::whereIn('id', $likes)->get();


        return view('vendor.index', [
            'Title' => 'Reseller',
            'favorits' => $favorits,
            'Habis' => $products['habis'],
            'Products' => $products['data'],
            'Pending' => $products['pending'],
            'Verified' => $products['verified'],
            'Notifications' => NotificationController::notifReseller(),
        ]);
    }

    /**
     * Menampilkan detail produk.
     * Memeriksa apakah produk milik user yang sedang login dan menampilkan detail produk.
     */
    public function show(Produk $produk)
    {
        $user = Auth::user();
        if (!$this->isUserProductOwner($user, $produk)) {
            return back()->with('error', 'Data Tidak Ditemukan!');
        }

        return view('vendor.show', [
            'Title' => 'Show',
            'User' => $this->getUserData($user->id),
            'Produk' => $produk,
            'Notifications' => NotificationController::notifReseller(),
        ]);
    }

    /* Menampilkan Product Unggulan */
    public function unggulan()
    {
        $user = Auth::user();
        $product = Unggulan::with("produk")->where("user_id", $user->id)->get();

        return view("vendor.unggulan", [
            "Title" => "Featured Product",
            "Products" => $product,
            "Notifications" => NotificationController::notifReseller()
        ]);
    }

    public function favorite()
    {
        $userId = Auth::user();
        $likes = Like::where('user_id', $userId->id)->pluck('produk_id');
        $favorits = Produk::whereIn('id', $likes)->get();


        return view('vendor.favorite', [
            'Title' => 'favorite',
            'favorits' => $favorits,
            'Notifications' => NotificationController::notifReseller(),
        ]);
    }

    /* Menampilkan profil pengguna.*/
    public function profil()
    {
        $userId = Auth::id();
        $data = DataUser::where('user_id', $userId)->first(); // Gunakan `first()` jika hanya satu data yang diharapkan

        return view('vendor.profil', [
            'Title' => 'Profil',
            'Data' => $data,
            'Notifications' => NotificationController::notifReseller(),
        ]);
    }

    /**
     * Memperbarui profil pengguna.
     * Memvalidasi dan memperbarui password pengguna.
     */
    public function updateProfil(Request $request)
    {
        $this->validatePasswordUpdate($request);

        $user = Auth::user();
        if (!$this->isOldPasswordCorrect($request->old, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }




    /**
     * Mengambil produk berdasarkan user dan menghitung status produk.
     */
    private function getUserProducts($userId)
    {
        $products = Produk::with(['user', 'kategori', 'status', 'unggulan'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'data' => $products,
            'habis' => $products->where('status.status', 'Habis')->count(),
            'pending' => $products->where('verified', false)->count(),
            'verified' => $products->where('verified', true)->count(),
        ];
    }


    /**
     * Memeriksa apakah produk dimiliki oleh user yang sedang login.
     */
    private function isUserProductOwner($user, $produk)
    {
        return $user->id === $produk->user_id;
    }


    /**
     * Mengambil data pengguna berdasarkan ID.
     */
    private function getUserData($userId)
    {
        return DataUser::where('user_id', $userId)->first();
    }


    /**
     * Memvalidasi input untuk pembaruan password.
     */
    private function validatePasswordUpdate(Request $request)
    {
        $request->validate([
            'old' => 'required',
            'password' => 'required|min:5|max:255',
            'confirm' => 'required|same:password',
        ], [
            'confirm.same' => 'Password tidak sama',
        ]);
    }


    /**
     * Memeriksa apakah password lama yang dimasukkan benar.
     */
    private function isOldPasswordCorrect($oldPassword, $hashedPassword)
    {
        return Hash::check($oldPassword, $hashedPassword);
    }
}
