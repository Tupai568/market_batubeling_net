<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Unggulan;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index()
    {
        $products = Produk::with('image')
            ->where('verified', 1)
            ->orderByRaw('status_id = 1 DESC') // Prioritaskan status_id = 1
            ->paginate(30);

        $limits = $products->take(4);
        $slices = $products->slice(4, 4); // Lewatkan 4 produk pertama, ambil 4 produk berikutnya

        $categories = Kategori::with("produks")->get();
        $unggulans = Unggulan::with("produk")->get();

        $limitsCategories = $categories->take(4);
        $slicesCategories = $categories->slice(4); // Lewatkan 4 produk pertama, ambil  produk berikutnya

        $data = [
            "limits" => $limits,
            "slices" => $slices,
            "products" => $products,
            "unggulans" => $unggulans,
            "categories" => $categories,
            "limitsCategories" => $limitsCategories,
            "slicesCategories" => $slicesCategories

        ];

        return view("home.testing", $data);
    }
}
