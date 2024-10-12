<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Produk;
use App\Models\Status;
use App\Models\DataUser;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;

class GetAdminController extends Controller
{

    public static function total()
    {
        // Hitung jumlah produk dengan status "Habis"
        $soldOutProductsCount = Produk::where('status_id', 2)->count();

        // Hitung jumlah produk dengan status "Tersedia"
        $availableProductsCount = Produk::where('status_id', 1)->count();

        return [
            "Tersedia" => $availableProductsCount,
            "Habis" => $soldOutProductsCount
        ];
    }

    // Mengambil data user dan menghitung pengguna yang statusnya 0
    public static function userPending()
    {
        $userPending = DataUser::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 0);
            })
            ->count();

        return $userPending;
    }


    //GET halaman dashboard admin
    public function index()
    {
        // Mengambil total data produk
        $total = self::total();

        // Mengambil ID status "Habis" dari tabel statuses
        $soldOutStatusId = Status::where('status', 'Habis')->value('id');

        // Mengambil semua reseller dengan jumlah produk yang terjual habis
        $resellers = User::withCount([
            'Produks as Habis' => fn($query) => $query->where('status_id', $soldOutStatusId)
        ])->where('is_admin', 0)->get();

        // Mengembalikan tampilan dengan data yang diperlukan
        return view('admin.index', [
            'Title' => 'SuperAdmin', // Judul halaman
            'sold' => $total['Habis'], // Jumlah produk terjual habis
            'Resellers' => $resellers, // Daftar reseller
            'Total' => Produk::count(), // Total produk
            'Tersedia' => $total['Tersedia'], // Jumlah produk tersedia
            'userPending' => self::userPending(), // Jumlah pengguna dengan status pending
            'pending' => Produk::where('verified', 0)->count(), // Jumlah produk yang pending
            'Notifications' => NotificationController::notif(), // Mengambil notifikasi
        ]);
    }


    //GET halaman profil admin
    public function profil()
    {
        // Menghitung jumlah produk yang belum terverifikasi
        $pending = Produk::where('verified', 0)->count();

        // Mengembalikan view dengan data yang diperlukan
        return view("admin.profil", [
            "Title" => "Profil",
            "pending" => $pending,
            "userPending" => self::userPending(),
            "Notifications" => NotificationController::notif()
        ]);
    }


    //GET halaman table product
    public function product()
    {
        // Mengambil total produk yang tersedia dan habis
        $total = $this->total();

        // Mengambil produk dengan relasi status dan image, terurut berdasarkan updated_at
        $products = Produk::with(['status', 'image', 'kategori'])
            ->latest('updated_at')
            ->get();

        // Menghitung jumlah produk yang belum terverifikasi
        $pending = $products->where("verified", 0)->count();

        // Mengembalikan view dengan data yang diperlukan
        return view("admin.table_produk", [
            "Title" => "Total Produk SuperAdmin",
            "pending" => $pending,
            "Products" => $products,
            "sold" => $total["Habis"],
            "Tersedia" => $total["Tersedia"],
            "userPending" => self::userPending(),
            "Notifications" => NotificationController::notif()
        ]);
    }


    //GET halaman confirmation user
    public function userConfirm()
    {
        $dataUser = DataUser::with("user")->get();
        $pending = Produk::where("verified", 0)->count();

        return view("admin.table_verified", [
            "Title" => "Confirmation User",
            "Data" => $dataUser,
            "pending" => $pending,
            "userPending" => self::userPending(),
            "Notifications" => NotificationController::notif()
        ]);
    }


    //GET halaman verified dataUser
    public function UserVerified(User $user)
    {
        // Mengambil data user berdasarkan user_id
        $dataUser = DataUser::with('user')->where('user_id', $user->id)->first();

        // Menghitung jumlah produk yang belum terverifikasi
        $pending = Produk::where("verified", 0)->count();

        // Periksa apakah data user ditemukan
        if (!$dataUser) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // Periksa apakah NIK telah diisi
        if (empty($dataUser->nik)) {
            return back()->with('error', 'Data belum diisi oleh user');
        }

        $status = (bool) $dataUser->user->status;

        // Tampilkan tampilan dengan data yang diperlukan
        return view('admin.verified_profil', [
            'Title' => 'Verified Profil',
            'Data' => $dataUser,
            'Status' => $status,
            'pending' => $pending,
            'userPending' => self::userPending(),
            'Notifications' => NotificationController::notif()
        ]);
    }


    //GET Halaman membership
    public function showMembership(User $user)
    {
        $membership = ["basic", "store", "agent", "mall"];
        $pending = Produk::where("verified", 0)->count();

        return view("admin.membership", [
            "Title" => "Membership",
            "Data" => $user,
            "pending" => $pending,
            "Members" => $membership,
            "userPending" => self::userPending(),
            "Notifications" => NotificationController::notif()
        ]);
    }
}
