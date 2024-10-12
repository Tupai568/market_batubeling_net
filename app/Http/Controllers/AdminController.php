<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Status;
use App\Models\DataUser;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\IsAdmin;


class AdminController extends Controller
{

    public function total()
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

    public function index()
    {
        $total = $this->total();

        // Ambil ID status "terjual habis" dari tabel statuses
        $soldOutStatusId = Status::where('status', 'Habis')->pluck('id')->first();
        $pending = Produk::where("verified", 0)->count();

        // Ambil semua reseller dengan jumlah produk yang terjual
        $resellers = User::withCount([
            'Produks as Habis' => function ($query) use ($soldOutStatusId) {
                // Hitung produk yang statusnya "Sold Out"
                $query->where('status_id', $soldOutStatusId);
            }
        ])->where("is_admin", 0)->get();

        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.index", [
            "Title" => "SuperAdmin",
            "Total" => Produk::all()->count(),
            "Resellers" => $resellers,
            "Tersedia" => $total["Tersedia"],
            "sold" => $total["Habis"],
            "pending" => $pending,
            "userPending" => $userPending,
            "Notifications" => NotificationController::notif()
        ]);
    }

    public function profil()
    {
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();
        $pending = Produk::where("verified", 0)->count();
        return view("admin.profil", [
            "Title" => "Profil Admin",
            "pending" => $pending,
            "userPending" => $userPending,
            "Notifications" => NotificationController::notif()
        ]);
    }

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

    public function product()
    {
        $total = $this->total();

        $products = Produk::with(['status', 'image'])
            ->latest('updated_at') // Mengurutkan berdasarkan kolom 'updated_at'
            ->get();

        $pending = $products->where("verified", 0)->count();
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.table_produk", [
            "Title" => "Total Produk SuperAdmin",
            "Products" => $products,
            "Tersedia" => $total["Tersedia"],
            "pending" => $pending,
            "userPending" => $userPending,
            "sold" => $total["Habis"],
            "Notifications" => NotificationController::notif()
        ]);
    }

    //Verified produk
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

    //table data user yang sudah mengisi data
    public function userConfirm()
    {
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        $pending = Produk::where("verified", 0)->count();


        return view("admin.table_verified", [
            "pending" => $pending,
            "userPending" => $userPending,
            "Title" => "userConfirm",
            "Data" => $Data,
            "Notifications" => NotificationController::notif()
        ]);
    }

    //tampilan data user
    public function UserVerified(User $user)
    {
        $dataUser = DataUser::with('user')->where('user_id', $user->id)->first();
        $pending = Produk::where("verified", 0)->count();
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        // Periksa apakah data user ditemukan
        if (!$dataUser) {
            return back()->with('error', 'Data not found');
        }

        // Periksa apakah NIK telah diisi
        if (empty($dataUser->nik)) {
            return back()->with('error', 'Data belum diisi oleh user');
        }

        $status = (bool) $dataUser->user->status;

        // Tampilkan tampilan dengan data yang diperlukan
        return view('admin.verified_profil', [
            'Title' => 'Verified Profil',
            'pending' => $pending,
            "userPending" => $userPending,
            'Data' => $dataUser,
            'Status' => $status,
            "Notifications" => NotificationController::notif()
        ]);
    }

    //update status user
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

    //Untuk Tampilan Membership
    public function showMembership(User $user)
    {
        $membership = ["basic", "store", "agent", "mall"];
        $pending = Produk::where("verified", 0)->count();
        $Data = DataUser::with("user")->get();
        $arr = $Data->pluck('user_id');

        // Memastikan $arr adalah array
        $arr = $arr->toArray();
        $userPending = User::whereIn("id", $arr)->where("status", 0)->count();

        return view("admin.membership", [
            "Title" => "Membership",
            "pending" => $pending,
            "userPending" => $userPending,
            "Members" => $membership,
            "Data" => $user,
            "Notifications" => NotificationController::notif()
        ]);
    }

    //Untuk Update Membership 
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
}
