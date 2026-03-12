{{-- pages/gallery.blade.php --}}
@extends('layouts.home')

@section('title', 'School Gallery')
@section('meta_description', 'Explore albums from school events, programs, and celebrations at Taboc Elementary School.')

@section('page_content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero__actions">
            <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">Back to Home</a>
        </div>
        <h1 class="page-hero__title">School Gallery</h1>
        <p class="page-hero__subtitle">Browse albums from school activities, events, and student achievements.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($albums->count())
            <div class="album-grid">
                @foreach($albums as $album)
                    @php
                        $albumPhotos = $album->photos->take(4);
                        $photoCount = $album->published_photos_count ?? $album->photos_count ?? $album->photos->count();
                    @endphp
                    <a href="{{ route('gallery.show', $album) }}" class="album-card">
                        <div class="album-collage">
                            @forelse($albumPhotos as $photo)
                                @php
                                    $caption = $photo->caption ?: ($photo->original_name ?: 'Album photo');
                                    $slotClass = $loop->first ? 'album-collage__item--lg' : '';
                                @endphp
                                <div class="album-collage__item {{ $slotClass }}">
                                    <img src="{{ $photo->url }}"
                                         alt="{{ $caption }}"
                                         loading="lazy"
                                         decoding="async" />
                                </div>
                            @empty
                                <div class="album-collage__empty">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>No photos yet</span>
                                </div>
                            @endforelse
                        </div>
                        <div class="album-card__meta">
                            <p class="album-card__title">{{ $album->name }}</p>
                            <p class="album-card__count">{{ $photoCount }} photo{{ $photoCount === 1 ? '' : 's' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="public-empty">
                <p class="public-empty__title">No gallery albums yet</p>
                <p class="public-empty__desc">Albums will appear here once photos are published.</p>
            </div>
        @endif
    </div>
</section>
@endsection
