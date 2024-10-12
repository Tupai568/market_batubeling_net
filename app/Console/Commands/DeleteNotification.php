<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class DeleteNotification extends Command
{
    protected $signature = 'notifications:delete-old';
    protected $description = 'Delete notifications older than 1 month and send a message to the sender';

    public function handle()
    {
        // Menghapus notifikasi yang lebih tua dari 1 bulan
        $deleted = Notification::where('updated_at', '<', Carbon::now()->subMonth())->get();

        foreach ($deleted as $delet) {
            $filePath = public_path('img/promo/' . $delet->image);

            if (File::exists($filePath)) {
                // Hapus file
                File::delete($filePath);
            }
        }

        $deleted = Notification::where('updated_at', '<', Carbon::now()->subMonth())->delete();

        $this->info($deleted . ' old notifications deleted.');
    }
}
