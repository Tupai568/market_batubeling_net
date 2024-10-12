<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Merchant;
use App\Models\Unggulan;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Notification $notif)
    {

        $notification = Notification::with(["Produk", "User"])
            ->where("id", $notif->id)
            ->where("tujuan", "admin")
            ->first();

        if (!$notification) {
            return back()->with("error", "Notif Tidak Di Temukan!!");
        }

        if ($notif->reat_at == null) {
            Notification::where('id', $notif->id)->update(["reat_at" => Carbon::now()]);
        }

        $user = $notification->user;
        $pending = Produk::where("verified", 0)->count();
        $unggulan = Unggulan::where("produk_id", $notif->produk_id)->first();
        $merchant = Merchant::where("user_id", $user->id)->first();

        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.notification", [
            "Title" => "notif",
            "product" => $notification->produk,
            "user" => $user,
            "message" => $notif,
            "unggulan" => $unggulan,
            "merchant" => $merchant,
            "pending" => $pending,
            "userPending" => $userPending,
            "Notifications" => self::notif(),
        ]);
    }

    public function indexReseller(Notification $notif)
    {

        $notification = Notification::with(["Produk", "User"])
            ->where("id", $notif->id)
            ->where("tujuan", "reseller")
            ->first();

        if (!$notification) {
            return back()->with("error", "Notif Tidak Di Temukan!!");
        }

        if ($notif->reat_at == null) {
            Notification::where('id', $notif->id)->update(["reat_at" => Carbon::now()]);
        }

        $unggulan = Unggulan::where("produk_id", $notif->produk_id)->first();

        return view("vendor.notification", [
            "Title" => "notif",
            "product" => $notification->produk,
            "user" => $notification->user,
            "message" => $notif,
            "unggulan" => $unggulan,
            "Notifications" => self::notifReseller(),
        ]);
    }

    public static function notif()
    {
        $respons = Notification::with(["produk", "user"])
            ->where("tujuan", "admin")
            ->orderBy('created_at', 'desc')
            ->get();

        return $respons;
    }

    public static function totalNotif()
    {
        //total notif yang belum dibaca
        $respons = Notification::where('tujuan', 'admin')
            ->whereNull('reat_at')
            ->count();

        return response()->json(['success' => true, 'message' => $respons]);
    }

    public static function notifReseller()
    {
        $respons = Notification::with(["produk", "user"])
            ->where("tujuan", "reseller")
            ->orderBy('created_at', 'desc')
            ->get();

        return $respons;
    }

    public static function ambilTigaKataPertama($teks)
    {
        // Pisahkan teks menjadi array kata
        $kata = explode(' ', $teks);

        // Ambil 3 kata pertama
        $tigaKata = array_slice($kata, 0, 3);

        // Gabungkan kembali menjadi string
        return implode(' ', $tigaKata);
    }

    public static function totalNotifReseller()
    {
        //total notif yang belum dibaca
        $respons = Notification::where('tujuan', 'reseller')
            ->whereNull('reat_at')
            ->count();

        return response()->json(['success' => true, 'message' => $respons]);
    }

    public static function DeleteNotifications()
    {
        $deleted = Notification::where('created_at', '<', Carbon::now()->subMonth())->delete();
    }


    public function delete(Request $request)
    {
        $validate = $request->validate([
            "id" => "required",
            "user_id" => "required",
            "tujuan" => "required",
            "message" => "required"
        ]);

        $validate["tujuan"] = "reseller";
        $validate["reat_at"] = null;
        Notification::where('id', $request->id)->update($validate);

        return redirect('/Admin')->with('error', 'Pembayaran Ditolak');
    }
}
