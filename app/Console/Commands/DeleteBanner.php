<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Baner;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeleteBanner extends Command
{
    protected $signature = 'baners:delete-old';
    protected $description = 'Delete banners older than 1 month and send a message to the sender';

    public function handle()
    {
        // Menghapus notifikasi yang lebih tua dari 1 bulan
        $deleted = Baner::where('updated_at', '<', Carbon::now()->subMonth())->get();

        foreach ($deleted as $delet) {

            $data = [
                "user_id" => $delet->user_id,
                "message" => "Masa Iklan Baner Toko Anda Telah Selesai",
                "action" => "store"
            ];

            Notification::create($data);

            $filePath = public_path('img/baner/' . $delet->image);

            if (File::exists($filePath)) {
                // Hapus file
                File::delete($filePath);
            }
        }

        $deleted = Baner::where('updated_at', '<', Carbon::now()->subMonth())->delete();

        $this->info($deleted . ' old baners deleted.');
    }
}
