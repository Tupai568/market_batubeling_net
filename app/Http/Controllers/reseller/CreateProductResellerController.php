<?php

namespace App\Http\Controllers\reseller;

use App\Models\Image;
use App\Models\Produk;
use App\Models\DataUser;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\NotificationController;
use Intervention\Image\Laravel\Facades\Image as magick;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;


class CreateProductResellerController extends Controller
{

    /* Start Function Utama */
    public function create()
    {
        return view('vendor.upload', [
            "Title" => "Upload Produk",
            "Categories" => Kategori::all(),
            "Provinsis" => config('provinsi'),
            "Notifications" => NotificationController::notifReseller(),
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi dan format data input
        $validatedData = $this->validateRequest($request);

        // Cek data user reseller dan kondisi lainnya
        $userData = DataUser::where('user_id', $user->id)->first();

        if (empty($userData->whatsapp)) {
            return redirect('/Setting')->with('error', 'Mohon Lengkapi Data!');
        }

        if ($user->status != 1) {
            return redirect('/Setting')->with('error', 'Data Anda Sedang Ditinjau');
        }

        if ($this->isResellerLimitExceeded($user)) {
            return back()->with('warning', '<a href="">Hubungi Admin Untuk Upgrade Ke Versi Lainnya</a>');
        }

        // Validasi dan simpan gambar
        $imageData = $this->handleImageUpload($request);
        if (!$imageData) {
            return back()->with('error', 'Gagal mengupload gambar.');
        }

        // Simpan produk
        $validatedData["image_id"] = Image::create($imageData)->id;
        Produk::create($validatedData);

        return back()->with('success', 'Success Upload Produk!');
    }


    /* End Function Utama */



    /* Start Function Dukungan */

    private function validateRequest($request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z0-9\s\-]+$/|max:255',
            'descripsi' => 'required|string|min:10',
            'harga' => 'required|integer',
            'kondisi' => 'required',
            'alamat' => 'required',
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategoris,id'
        ], [
            'name.required' => 'Nama Produk harus diisi.',
            'descripsi.min' => 'Deskripsi harus terdiri dari minimal 10 karakter.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
        ]);

        $validatedData['harga'] = number_format(preg_replace('/\D/', '', $request->input('harga')), 0, ',', '.');
        $validatedData['status_id'] = 1;

        return $validatedData;
    }


    private function isResellerLimitExceeded($user)
    {
        $productsCount = Produk::where('user_id', $user->id)->count();
        return $productsCount >= $user->product_limit;
    }


    private function handleImageUpload($request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'imageSatu' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'imageDua' => 'required|image|mimes:jpg,jpeg,png|max:1024',
            'imageTiga' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'image.max' => 'File size for Image must not exceed 1 MB.',
            'imageSatu.max' => 'File size for Image must not exceed 1 MB.',
            'imageDua.max' => 'File size for Image must not exceed 1 MB.',
            'imageTiga.max' => 'File size for Image must not exceed 1 MB.',
        ]);

        $images = ['image', 'imageSatu', 'imageDua', 'imageTiga'];
        $destinationPath = public_path('img/produk');
        $watermarkPath = public_path('img/watermak.png'); // Path ke gambar watermark
        $imageData = [];

        foreach ($images as $key) {
            $file = $request->file($key);
            $fileName = 'product' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $destinationPath . '/' . $fileName;
            $file->move($destinationPath, $fileName);

            //tempat untuk menyimpan gambar
            $outputFilePath = $destinationPath . '/' . 'product' . Str::uuid() . '.webp';

            // Panggil fungsi untuk meresize gambar
            $newfile = $this->resizeImage($filePath, $outputFilePath, $watermarkPath); 

            //delete gambar
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $imageData[$key] = $newfile;
        }

        return $imageData;
    }


    private function resizeImage($imagePath, $outputPath, $watermark)
    {
        // Membaca gambar menggunakan Intervention Image
        $image = magick::read($imagePath);

        //memberikan watermark
        // $image->place($watermark, 'bottom-right');

        // ubah gambar ke webp
        $image->encode(new WebpEncoder(quality: 75)); // Intervention\Image\EncodedImage

        // Simpan gambar yang sudah diubah ukurannya
        $image->save($outputPath);

        return basename($outputPath);
    }

    /* End Function Dukungan */
}
