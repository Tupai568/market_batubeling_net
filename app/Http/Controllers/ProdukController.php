<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Image;
use App\Models\Baner;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\Merchant;
use App\Models\Unggulan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProdukController extends Controller
{

    public static function listProduct()
    {
        // Menghitung produk berdasarkan kata kunci
        $keywords = ['sepeda', 'sepatu', 'rumah', 'mobil', 'buku', 'baju'];

        return $keywords;
    }



    public function index()
    {
        // Mengambil produk yang sudah diverifikasi
        $products = Produk::with('image', 'kategori', 'status')
            ->where('verified', 1)
            ->orderByRaw('status_id = 1 DESC')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // Mengambil produk teratas dan membagi
        $limits = $products->take(4);
        $slices = $products->slice(4, 4);

        // Fungsi untuk mengambil produk berdasarkan kriteria tertentu
        $getProducts = function ($orderBy, $limit = 8) {
            return Produk::with(['image', 'likes', 'kategori', 'status'])
                ->where('verified', 1)
                ->withCount('likes')
                ->orderBy($orderBy, 'desc')
                ->take($limit)
                ->get();
        };

        // Mengambil produk dengan likes terbanyak
        $likes = $getProducts('likes_count');
        $limitsLike = $likes->take(4);
        $slicesLike = $likes->slice(4);

        // Mengambil produk yang paling banyak dilihat
        $trending = $getProducts('views');
        $limitsTrending = $trending->take(4);
        $slicesTrending = $trending->slice(4);

        // Mengambil kategori dan unggulan
        $categories = Kategori::with('produks')->get();
        $unggulans = Unggulan::with('produk.image')->get();

        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4);

        // Mengambil banner
        $baners = Baner::with('User')->get();

        // Menghitung produk berdasarkan kata kunci
        $keywords = ['jam', 'bonsai', 'buku', 'mobil', 'sepeda'];
        $dataCounts = collect($keywords)->mapWithKeys(function ($keyword) {
            return [$keyword => Produk::where('name', 'LIKE', "%$keyword%")->count()];
        })->toArray();

        $data = array_merge($dataCounts, [
            'list' => self::listProduct(),
            'baners' => $baners,
            'limits' => $limits,
            'slices' => $slices,
            'products' => $products,
            'unggulans' => $unggulans,
            'categories' => $categories,
            'limitsLike' => $limitsLike,
            'slicesLikes' => $slicesLike,
            'limitsTrending' => $limitsTrending,
            'slicesTrending' => $slicesTrending,
            'limitsCategories' => $limitsCategories,
            'slicesCategories' => $slicesCategories,
        ]);

        return view('home.index', $data);
    }



    public function show($name, $id)
    {

        $unggulans = Unggulan::with("produk.image")->get();

        $detail = Produk::with(["user", "image"])
            ->where('id', $id)
            ->where("name", $name)
            ->firstOrFail();

        if (!request()->cookie('views' . $id)) {
            $detail->increment('views');
            // Buat cookie yang kadaluwarsa setelah 24 jam
            cookie()->queue('views' . $id, true, 1440); // 1440 = 24 jam
        }

        $user = $detail->user;

        $dataUser = DataUser::where("user_id", $user->id)->first();

        $categories = Kategori::with("produks")->get();
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        $products = Produk::with('image', 'kategori', 'status')
            ->where('verified', 1)
            ->orderByRaw('status_id = 1 DESC')
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru
            ->paginate(30);


        $limits = $products->take(4);


        $data = [
            "limits" => $limits,
            "detail" => $detail,
            "userID" => $user->id,
            "products" => $products,
            "dataUser" => $dataUser,
            "unggulans" => $unggulans,
            "profile" => $user->profile,
            "categories" => $categories,
            'list' => self::listProduct(),
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories,

        ];

        return view('home.detail', $data);
    }


    public function categories($name)
    {

        $categories = Kategori::all();
        $unggulans = Unggulan::with("produk")->get();

        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya
        $categorie = $categories->where("name", $name)->first();
        if (!$categorie) {
            return redirect()->route('home');
        }

        $products = Produk::where("kategori_id", $categorie->id)
            ->where('verified', 1)
            ->orderByRaw('status_id = 1 DESC')
            ->paginate(30);
        $limits = $products->take(4);


        $data = [
            "limits" => $limits,
            "products" => $products,
            "categoriName" => $name,
            "unggulans" => $unggulans,
            "categories" => $categories,
            'list' => self::listProduct(),
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories,
        ];
        return view('home.categorie', $data);
    }


    public function search(Request $request)
    {
        $request->validate(["search" => "string|max:255"]);
        $categories = Kategori::all();
        $unggulan = Unggulan::all();
        $search = $request->input('search');
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        if (isset($search)) {

            $products = Produk::where('name', 'LIKE', '%' . $search . '%')
                ->where('verified', 1)
                ->orderBy('views', 'desc')
                ->get();

            $data = [
                "name" => $search,
                "limits" => $unggulan,
                "products" => $products,
                "categories" => $categories,
                'list' => self::listProduct(),
                "limitsCategories" => $limitsCategories,
                "slicesCategories" => $slicesCategories,
            ];

            return view('home.search', $data);
        }
    }


    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:produks,id'
        ]);

        // Ambil ID yang telah divalidasi
        $id = $validated['id'];

        // Lakukan sesuatu dengan ID yang valid
        $produk = Produk::findOrFail($id);
        $image = Image::findOrFail($produk->image_id);

        $imageFiles = json_decode($produk->image, true); // Mengambil JSON array dari kolom 'images'
        $Notif = Notification::where("produk_id", $produk->id)->first();

        return $Notif;

        if ($Notif !== null && $Notif->image !== null) {
            $filePath = public_path('img/promo/' . $Notif->image);

            // Periksa apakah file ada
            if (File::exists($filePath)) {
                // Hapus file
                File::delete($filePath);
            }
        }

        foreach ($imageFiles as $fileName) {
            $filePath = public_path('img/produk/' . $fileName);

            if (file_exists($filePath)) {
                // Hapus file
                File::delete($filePath);
            }
        }


        $produk->delete();
        $image->delete();

        return back()->with("warning", "Succsess Meghapus Product");
    }


    public function merchant($profile, Request $request)
    {
        $users = User::with("DataUser")->where("profile", $profile)->first();
        $categories = Kategori::with("produks")->get();
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        if ($users == null) {
            return redirect()->route('home');
        }

        $store = Merchant::where("user_id", $users->id)->first();

        $products = Produk::with('image', 'kategori', 'status')
            ->where("user_id", $users->id)
            ->where('verified', 1)
            ->orderByRaw('status_id = 1 DESC') // Prioritaskan status_id = 1
            ->paginate(30);
        $limits = $products->take(4);

        // return $users;

        $data = [
            "users" => $users,
            "store" =>  $store,
            "limits" => $limits,
            "products" => $products,
            "categories" => $categories,
            'list' => self::listProduct(),
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories
        ];

        return view("home.store", $data);
    }


    public function about()
    {
        $categories = Kategori::with("produks")->get();
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        return view("home.about", [
            "Title" => "Tentang Kami",
            'list' => self::listProduct(),
            "categories" => $categories,
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories,
        ]);
    }


    public function terms()
    {
        $categories = Kategori::with("produks")->get();
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        return view("home.terms", [
            "Title" => "Terms and Conditions",
            'list' => self::listProduct(),
            "categories" => $categories,
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories,
        ]);
    }

    //privacy
    public function privacy()
    {
        $categories = Kategori::with("produks")->get();
        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        return view("home.privasi", [
            "Title" => "privacy policy",
            'list' => self::listProduct(),
            "categories" => $categories,
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories,
        ]);
    }
}
