<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Baner;
use App\Models\Produk;
use App\Models\DataUser;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BannerController extends Controller
{
    public function index()
    {
        $pending = Produk::where("verified", 0)->count();
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.table_banner", [
            "Title" => "iklanBanner",
            "Data" => Baner::all(),
            "pending" => $pending,
            "userPending" => $userPending,
            "Notifications" => NotificationController::notif()
        ]);
    }

    public function sendNotifBanner(Request $request)
    {
        $validateData = $request->validate([
            "image" => "required|image|file|max:1024",
            "user_id" => "required|exists:users,id",
        ]);

        $validateData["tujuan"] = "admin";
        $validateData["action"] = "store";

        $user = User::findOrFail($request->user_id);

        //Cek Apakah User Pernah Mengirim Notifikasi
        $cekNotif = Notification::where("user_id", $user->id)
            ->where("tujuan", "admin")
            ->where("action", "store")
            ->exists();

        if ($cekNotif) {
            return back()->with('error', 'Mohon Ditinggu Pembayaran Anda Sedang Ditinjau');
        }

        // Ambil file dari permintaan
        $file = $request->file('image');

        // Tentukan path penyimpanan di folder public/img/produk
        $destinationPath = public_path('img/promo');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Pindahkan file ke lokasi yang diinginkan
        $file->move($destinationPath, $fileName);
        $validateData['image'] = $fileName;
        $validateData['message'] = "Mendaftarkan Toko Nya Untuk Diiklankan";

        Notification::create($validateData); //Upload Data
        return back()->with('warning', 'Pembayaran Anda Akan Ditinjau 1x24Jam');
    }

    public function store(Request $request)
    {

        $request->validate([
            "id" => "required|exists:notifications,id",
            "user_id" => "required|exists:users,id",
            "message" => "required",
        ]);

        //create data banner
        $validateData = $request->validate([
            "user_id" => "required",
            "image" => "required|image|file|max:1024",
        ]);

        //cek table banner
        $cekBanner = Baner::where("user_id", $request->user_id)->first();
        if ($cekBanner) {
            return redirect("/Admin/Banner")->with('error', 'Toko Sudah Diiklankan Sebelum Nya');
        }

        //update table notification
        $notif = Notification::findOrFail($request->id);
        $notif->tujuan = "reseller";
        $notif->submit = "confirm";
        $notif->message = $request->message;
        $notif->reat_at = null;
        $notif->save(); // Pastikan untuk menyimpan perubahan

        // Ambil file dari permintaan
        $file = $request->file('image');

        // Tentukan path penyimpanan di folder public/img/produk
        $destinationPath = public_path('img/baner');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Pindahkan file ke lokasi yang diinginkan
        $file->move($destinationPath, $fileName);
        $validateData['image'] = $fileName;

        Baner::create($validateData);
        return redirect("/Admin/Banner")->with('success', 'Berhasil Mengirim Response');
    }

    public function destroy(Request $request)
    {
        $banner = Baner::findOrFail($request->id);

        $filePath = public_path('img/baner/' . $banner->image);

        if (File::exists($filePath)) {
            // Hapus file
            File::delete($filePath);
        }

        $banner->delete();

        return back()->with("success", "Berhasil Menghapus Data");
    }
}
