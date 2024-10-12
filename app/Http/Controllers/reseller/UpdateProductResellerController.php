<?php

namespace App\Http\Controllers\reseller;

use App\Models\Image;
use App\Models\Produk;
use App\Models\Status;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\NotificationController;
use Intervention\Image\Laravel\Facades\Image as magick;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;

class UpdateProductResellerController extends Controller
{

    /* Start Function Utama */

    public function edit(Produk $produk)
    {
        $user = Auth::user();

        // Cek kepemilikan produk
        if ($produk->user_id !== $user->id) {
            return redirect('/Reseller')->with('error', 'Produk Tidak Ditemukan!');
        }

        // Ambil data yang diperlukan
        $data = [
            'Title' => 'Produk',
            'Produk' => $produk,
            'Statuses' => Status::all(),
            'Categories' => Kategori::all(),
            'Provinsis' => $this->getProvinsi(),
            'Notifications' => $this->getNotifications(),
        ];

        return view('vendor.edit', $data);
    }



    public function update(Request $request, Produk $produk)
    {

        // Validasi data produk
        $validatedData = $this->validateProduct($request);

        // Format harga
        $validatedData['harga'] = $this->formatPrice($request->harga);

        // Simpan gambar dan hapus gambar lama
        $validatedImage = $this->handleImages($request);

        // Update Gambar dengan data yang telah diperbarui
        $image = Image::find($produk->image_id);
        $image->update($validatedImage);


        // Update produk dengan data yang telah divalidasi
        $produk->update($validatedData);

        // Reset revisi jika perlu
        if ($produk->revisi == 1) {
            $produk->update(['revisi' => 0]);
        }

        return redirect(route("dashboard"))->with('success', 'Berhasil update data');
    }

    /* End Function Utama */




    /* Start Function Dukungan */
    private function getNotifications()
    {
        return NotificationController::notifReseller();
    }


    private function getProvinsi()
    {
        return config('provinsi');
    }


    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z0-9\s\-]+$/|max:255',
            'descripsi' => 'required|string|min:10',
            'harga' => 'required|integer',
            'kondisi' => 'required',
            'alamat' => 'required',
            'status_id' => 'required|exists:statuses,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'imageSatu' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'imageDua' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'imageTiga' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);
    }


    private function formatPrice($price)
    {
        return number_format(preg_replace('/\D/', '', $price), 0, ',', '.');
    }


    private function handleImages(Request $request)
    {
        $images = ['image', 'imageSatu', 'imageDua', 'imageTiga'];
        $imageNames = [];
        $watermarkPath = public_path('img/watermark.png'); // Path ke gambar watermark

        foreach ($images as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $fileName = $this->storeImage($request->file($imageKey), $watermarkPath);
                $imageNames[$imageKey] = $fileName;
                $this->deleteOldImage($request->input('OLD' . $imageKey));
            }
        }

        return $imageNames;
    }


    private function storeImage($image, $watermarkPath)
    {
        $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('img/produk');
        $filePath = $destinationPath . '/' . $fileName;
        $image->move($destinationPath, $fileName);

        $outputFilePath = $destinationPath . '/' . 'product' . Str::uuid() . '.webp';


        $newfile = $this->resizeImage($filePath, $outputFilePath, $watermarkPath); // Resize ke 800x800 px

        //delete gambar
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        return $newfile;
    }


    private function deleteOldImage($oldFileName)
    {
        if ($oldFileName && File::exists(public_path('img/produk/' . $oldFileName))) {
            File::delete(public_path('img/produk/' . $oldFileName));
        }
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

    /* End Function Dukungan */
}
