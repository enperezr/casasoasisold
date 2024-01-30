<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach($static_urls as $url=>$data)
<url>
    <loc>{{$url}}</loc>
    <lastmod>{{Carbon\Carbon::now()->toAtomString()}}</lastmod>
    @if($data[1])
    <changefreq>{{$data[1]}}</changefreq>
    @endif
    <priority>{{$data[0]}}</priority>
</url> 
@endforeach
@foreach($search_urls as $url=>$data)
@if($data[1] > 1)
<url>
    <loc>{{$url}}</loc>
    <lastmod>{{Carbon\Carbon::now()->toAtomString()}}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>{{$data[0]}}</priority>
</url> 
@endif
@endforeach
@foreach($property_urls as $url=>$data)
<url>
    <loc>{{$url}}</loc>
    <lastmod>{{$data[2]->updated_at->toAtomString()}}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>{{$data[0]}}</priority>
</url>
@endforeach
</urlset>