<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Notification;
use App\Models\Unggulan;
use Illuminate\Console\Command;

class DeleteUnggulan extends Command
{
    protected $signature = 'unggulan:delete-old';
    protected $description = 'Delete product unggulan older than 1 month and send a message to the sender';

    public function handle()
    {
        $unggulan = Unggulan::where('updated_at', '<', Carbon::now()->subMonth())->get();


        foreach ($unggulan as $value) {
            $data = [
                "user_id" => $value->user_id,
                "produk_id" => $value->produk_id,
                "message" => "Masa Product Unggulan Anda Telah Selesai",
                "tujuan" => "reseller"
            ];

            Notification::create($data);
        }


        // Menghapus unggulan yang lebih tua dari 1 bulan
        $deleted = Unggulan::where('updated_at', '<', Carbon::now()->subMonth())->delete();

        $this->info($deleted . ' old product unggulan deleted.');
    }
}
