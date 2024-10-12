<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Daftar URL yang ingin ditambahkan
        $urls = [
            // Tambahkan URL yang ingin dimasukkan secara manual jika perlu
            url('/'),
            url('/about'),
            url('/contact'),
            url('/tentang'),
            url('/caraBerjualan'),
            url('/tentang'),
            url('/tentang'),
            url('/tentang'),
            url('/tentang'),
            url('/tentang'),
            url('/tentang'),
            url('/tentang'),
            // dan seterusnya
        ];

        // Secara otomatis ambil URL dari database atau model
        // Misalnya, jika ada model Post
        // foreach (Post::all() as $post) {
        // $urls[] = url('/posts/' . $post->slug);
        // }

        foreach ($urls as $url) {
            $sitemap->add(Url::create($url));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at ' . public_path('sitemap.xml'));
    }
}
