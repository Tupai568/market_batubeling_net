<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Unggulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UnggulanController extends Controller
{
    public function index()
    {
        $product = Unggulan::all();
        $pending = Produk::where("verified", 0)->count();
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.unggulan", [
            "Title" => "totalFeatured",
            "Products" => $product,
            "pending" => $pending,
            "userPending" => $userPending,
            "Notifications" => NotificationController::notif()
        ]);
    }

    public function indexReseller()
    {
        $user = Auth::user();
        $product = Unggulan::with("produk")->where("user_id", $user->id)->get();

        return view("vendor.unggulan", [
            "Title" => "Featured Product",
            "Products" => $product,
            "Notifications" => NotificationController::notifReseller()
        ]);
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            "user_id" => "required|exists:users,id",
            "produk_id" => "required|exists:produks,id"
        ]);

        $unggulan = Unggulan::count();
        $cekProduct = Unggulan::where("produk_id", $request->produk_id)->first();

        if ($unggulan == 20) {
            return back()->with('warning', 'Produk Unggulan Sudah Penuh');
        }

        if ($cekProduct) {
            // Jika produk sudah ada
            return back()->with('error', 'Produk sudah ada dalam daftar unggulan.');
        }

        // Menyimpan data baru ke dalam tabel Unggulan
        Unggulan::create($validate);

        // Redirect atau response setelah berhasil menyimpan
        return back()->with('success', 'Produk Unggulan berhasil ditambahkan.');
    }
}
