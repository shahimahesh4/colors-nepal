{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach([route('home'),route('about'),route('services.index'),route('portfolio.index'),route('blog.index'),route('hosting.index'),route('domains.index'),route('contact.create'),route('quote.create')] as $url)
<url><loc>{{ $url }}</loc></url>
@endforeach
@foreach($services as $service)<url><loc>{{ route('services.show',$service) }}</loc><lastmod>{{ $service->updated_at->toAtomString() }}</lastmod></url>@endforeach
@foreach($projects as $project)<url><loc>{{ route('portfolio.show',$project) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>@endforeach
@foreach($posts as $post)<url><loc>{{ route('blog.show',$post) }}</loc><lastmod>{{ $post->updated_at->toAtomString() }}</lastmod></url>@endforeach
</urlset>
