<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach ($products as $product)
        <url>
            <loc>{{ route('products.show', $product->slug) }}</loc>
            <lastmod>{{ $product->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>always</changefreq>
            <priority>{{ $product->stock_status == 'in_stock' ? '0.8' : '0.6' }}</priority>
            @if ($product->image)
                <image:image>
                    <image:loc>{{ asset('storage/' . $product->image) }}</image:loc>
                    <image:title>{{ htmlspecialchars($product->name) }}</image:title>
                </image:image>
            @endif

        </url>
    @endforeach

</urlset>
