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
        ]);

        $images = ['image', 'imageSatu', 'imageDua', 'imageTiga'];
        $destinationPath = public_path('img/produk');
        $watermarkPath = public_path('img/watermark.png'); // Path ke gambar watermark
        $imageData = [];

        foreach ($images as $key) {
            $file = $request->file($key);
            $fileName = 'product' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $destinationPath . '/' . $fileName;
            $file->move($destinationPath, $fileName);

            //tempat untuk menyimpan gambar
            $outputFilePath = $destinationPath . '/' . 'product' . Str::uuid() . '.webp';

            // Panggil fungsi untuk meresize gambar
            $newfile = $this->resizeImage($filePath, $outputFilePath, $watermarkPath); // Resize ke 800x800 px

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

        // Resize gambar dengan menjaga rasio
        $image->resize(800, 700);

        //memberikan watermark
        $image->place($watermark, 'bottom-right');

        //pertajam gambar 
        $image->sharpen(3); // Nilai 5 adalah contoh, sesuaikan sesuai kebutuhan

        // ubah gambar ke webp
        $image->encode(new WebpEncoder(quality: 75)); // Intervention\Image\EncodedImage

        // Simpan gambar yang sudah diubah ukurannya
        $image->save($outputPath);

        return basename($outputPath);
    }

    // private function addWatermark($imagePath, $watermarkPath, $outputPath)
    // {
    //     // Muat gambar utama
    //     $image = magick::read($imagePath);

    //     // Muat gambar watermark
    //     $watermark = magick::read($watermarkPath);

    //     // Tambahkan watermark ke gambar utama di posisi kanan bawah dengan offset 10px
    //     $image->insert($watermark, 'bottom-right');

    //     // Simpan gambar dengan watermark
    //     $image->save($outputPath);
    // }



    // private function addWatermark($imagePath, $watermarkPath, $outputPath)
    // {
    //     // Muat gambar utama
    //     $image = imagecreatefromjpeg($imagePath);
    //     if (!$image) {
    //         return;
    //     }

    //     // Muat gambar watermark
    //     $watermark = imagecreatefrompng($watermarkPath);
    //     if (!$watermark) {
    //         imagedestroy($image);
    //         return;
    //     }

    //     // Tentukan posisi watermark
    //     $watermarkWidth = imagesx($watermark);
    //     $watermarkHeight = imagesy($watermark);

    //     // Posisi watermark di sudut kanan bawah
    //     $imageWidth = imagesx($image);
    //     $imageHeight = imagesy($image);
    //     $destX = $imageWidth - $watermarkWidth - 10; // Offset 10px dari tepi kanan
    //     $destY = $imageHeight - $watermarkHeight - 10; // Offset 10px dari tepi bawah

    //     // Tambahkan watermark ke gambar utama
    //     imagecopy(
    //         $image,
    //         $watermark,
    //         $destX,
    //         $destY,
    //         0,
    //         0,
    //         $watermarkWidth,
    //         $watermarkHeight
    //     );

    //     // Simpan gambar dengan watermark
    //     imagejpeg($image, $outputPath);

    //     // Hapus gambar dari memori
    //     imagedestroy($image);
    //     imagedestroy($watermark);
    // }

    // private function addWatermark($imagePath, $watermarkPath, $outputPath)
    // {
    //     // Dapatkan ekstensi gambar utama
    //     $imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

    //     // Muat gambar utama berdasarkan ekstensi
    //     switch ($imageExtension) {
    //         case 'jpeg':
    //         case 'jpg':
    //             $image = imagecreatefromjpeg($imagePath);
    //             break;
    //         case 'png':
    //             $image = imagecreatefrompng($imagePath);
    //             break;
    //         case 'gif':
    //             $image = imagecreatefromgif($imagePath);
    //             break;
    //         default:
    //             return; // Format gambar tidak didukung
    //     }
    //     if (!$image) {
    //         return;
    //     }

    //     // Muat gambar watermark (diasumsikan PNG untuk watermark)
    //     $watermark = imagecreatefrompng($watermarkPath);
    //     if (!$watermark) {
    //         imagedestroy($image);
    //         return;
    //     }

    //     // Tentukan posisi watermark
    //     $watermarkWidth = imagesx($watermark);
    //     $watermarkHeight = imagesy($watermark);

    //     // Posisi watermark di sudut kanan bawah
    //     $imageWidth = imagesx($image);
    //     $imageHeight = imagesy($image);
    //     $destX = $imageWidth - $watermarkWidth - 10; // Offset 10px dari tepi kanan
    //     $destY = $imageHeight - $watermarkHeight - 10; // Offset 10px dari tepi bawah

    //     // Tambahkan watermark ke gambar utama
    //     imagecopy(
    //         $image,
    //         $watermark,
    //         $destX,
    //         $destY,
    //         0,
    //         0,
    //         $watermarkWidth,
    //         $watermarkHeight
    //     );

    //     // Simpan gambar dengan watermark sesuai dengan format gambar utama
    //     switch ($imageExtension) {
    //         case 'jpeg':
    //         case 'jpg':
    //             imagejpeg($image, $outputPath);
    //             break;
    //         case 'png':
    //             imagepng($image, $outputPath);
    //             break;
    //         case 'gif':
    //             imagegif($image, $outputPath);
    //             break;
    //     }

    //     // Hapus gambar dari memori
    //     imagedestroy($image);
    //     imagedestroy($watermark);
    // }




    /* End Function Dukungan */
}
