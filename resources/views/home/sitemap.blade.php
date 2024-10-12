<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">

    <!-- Tambahkan URL lainnya jika perlu -->
    <url>
        <loc>{{ env("APP_URL") }}</loc>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>

    @foreach ($links as $link)
        <url>
            <loc>{{ env("APP_URL") }}{{ $link }}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
    
    @foreach ($products as $product)
        <url>
            <loc>{{ route('detail-product', ['name' => $product->name, 'id' => $product->id]) }}</loc>
            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
