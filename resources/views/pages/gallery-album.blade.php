{{-- pages/gallery-album.blade.php --}}
@extends('layouts.home')

@section('title', $album->name . ' - School Gallery')
@section('meta_description', 'Photos from the ' . $album->name . ' album at Taboc Elementary School.')

@section('page_content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero__actions">
            <a href="{{ route('gallery.index') }}" class="btn btn--ghost btn--sm">Back to Albums</a>
        </div>
        <h1 class="page-hero__title">{{ $album->name }}</h1>
        <p class="page-hero__subtitle">
            {{ $album->description ?? 'Photos from this school album.' }}
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($photos->count())
            <div class="gallery-masonry">
                @foreach($photos as $photo)
                    @php
                        $caption = $photo->caption ?: ($photo->original_name ?: 'Album photo');
                    @endphp
                    <figure class="gallery-photo">
                        <img src="{{ $photo->url }}"
                             alt="{{ $caption }}"
                             loading="lazy"
                             decoding="async" />
                        <figcaption class="gallery-photo__caption">{{ Str::limit($caption, 80) }}</figcaption>
                    </figure>
                @endforeach
            </div>
            <div class="public-pagination">
                {{ $photos->links() }}
            </div>
        @else
            <div class="public-empty">
                <p class="public-empty__title">No photos in this album yet</p>
                <p class="public-empty__desc">Check back later for new uploads.</p>
            </div>
        @endif
    </div>
</section>
@endsection
