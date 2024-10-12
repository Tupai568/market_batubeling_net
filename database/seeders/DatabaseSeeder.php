<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Produk;
use App\Models\Status;
use App\Models\DataUser;
use App\Models\Kategori;
use App\Models\Unggulan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        User::create([
            "name" => "BatuBeling",
            "email" => "batubelingwebsite@gmail.com",
            "password" => bcrypt("Batubeling.568"),
            "user_type" => "reseller",
            "status" => 1,
            "is_admin" => 1,
            "email_verified_token" => "agsdfbasdufga",
            "email_verified_at" => date("Y-m-d H:i:s"),
            "profile" => Str::uuid(),

        ]);

        User::create([
            "name" => "Tupai",
            "email" => "mercon568@gmail.com",
            "password" => bcrypt("password"),
            "user_type" => "reseller",
            "status" => 1,
            "email_verified_token" => "agsdfbasdufga",
            "email_verified_at" => date("Y-m-d H:i:s"),
            "profile" => Str::uuid(),
        ]);

        User::create([
            "name" => "guest",
            "email" => "behrud411@gmail.com",
            "password" => bcrypt("password"),
            "user_type" => "reseller",
            "status" => 1,
            "email_verified_token" => "agsdfbasdufga",
            "email_verified_at" => date("Y-m-d H:i:s"),
            "profile" => Str::uuid(),
        ]);


        DataUser::create([
            "nik" => "1234567890123459",
            "image" => "gdsagdas.jpg",
            "whatsapp" => "085730251715",
            "alamat" => "Jln.Kedinding Lor Gg Flamboyan",
            "user_id" => 2,
        ]);

        DataUser::create([
            "nik" => "1234567890123456",
            "image" => "gdsagdas.jpg",
            "whatsapp" => "085730251715",
            "alamat" => "Jln.Kedinding Lor Gg Flamboyan",
            "user_id" => 3,
        ]);



        //Kategori
        $Kategori = ["Hoby", "Antik", "Bekas", "Islam", "Galery",  "Geray BB", "Unik"];

        foreach ($Kategori as  $value) {
            Kategori::create([
                "name" => $value
            ]);
        }

        Status::create([
            "status" => "Tersedia"
        ]);

        Status::create([
            "status" => "Habis"
        ]);


        //Product
        $Product = [
            "Baju Distroyet",
            "Sepeda Motor",
            "Mobil Kodok",
            "Krisna",
            "Ikan Salmon",
            "Ayam Bangkok",
            "Wong Asorr"
        ];

        for ($i = 1; $i < 21; $i++) {
            Image::create([
                "image" => "product" . ($i + 22) . ".jpg",
                "imageSatu" => "product" . ($i + 23) . ".jpg",
                "imageDua" => "product" . ($i + 22) . ".jpg",
                "imageTiga" => "product" . ($i + 23) . ".jpg"
            ]);

            Produk::create([
                'name' => $Product[mt_rand(0, 6)],
                'descripsi' => '<div>' . Str::slug(fake()->sentence(100)) . '</div>',
                'harga' => "1" . $i . "0.000",
                'kondisi' => "baru",
                'alamat' => "jakarta",
                "verified" => 1,
                "status_id" => mt_rand(1, 2),
                "image_id" => $i,
                "user_id" => 3,
                "kategori_id" => mt_rand(1, 5)
            ]);
        }

        for ($i = 1; $i < 20; $i++) {
            Unggulan::create([
                "user_id" => 3,
                "produk_id" => $i
            ]);
        }
    }
}
