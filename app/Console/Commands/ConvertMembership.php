<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Console\Command;


class ConvertMembership extends Command
{
    protected $signature = 'membership:basic';
    protected $description = 'kembalikan status membership ke basic';

    public function handle()
    {
        // Mengambil pengguna yang belum memperbarui status mereka selama lebih dari satu bulan
        $users = User::where('updated_at', '<', Carbon::now()->subMinute())->get();
        $this->info($users->count() . ' pengguna ditemukan.');

        foreach ($users as $user) {
            // Mengupdate membership
            $user->membership = 'basic';
            $user->save();

            // Mengambil produk pengguna
            $products = Produk::where('user_id', $user->id)->get();
            $count = 0;

            foreach ($products as $product) {
                if ($count < 5) {
                    $product->verified = 1; // Produk tidak pending
                } else {
                    $product->verified = 0; // Produk menjadi pending
                }
                $product->save();
                $count++;
            }
        }

        // Menampilkan jumlah pengguna yang diupdate
        $this->info('Status membership pengguna telah diubah ke basic.');
    }
}
