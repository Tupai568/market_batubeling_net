<?php

namespace App\Http\Controllers;

use App\Models\Produk;
// use Spatie\Sitemap\Sitemap;
// use Spatie\Sitemap\Tags\Url;


class SitemapController extends Controller
{
    public function sitemap()
    {
        $products = Produk::all(); // Ambil semua produk
        $links = ["/about"];

        $data = [
            "links" => $links,
            "products" => $products
        ];

        return response()->view('home.sitemap', $data)
            ->header('Content-Type', 'text/xml');

        return $sitemap;
    }
}
