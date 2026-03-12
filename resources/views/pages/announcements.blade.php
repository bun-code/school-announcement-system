{{-- pages/announcements.blade.php --}}
@extends('layouts.home')

@section('title', 'Announcements — Taboc Elementary School')
@section('meta_description', 'Read the latest announcements and official notices from Taboc Elementary School.')

@section('page_content')

@php
    $accentMap = [
        'Academic'  => 'card__accent-bar--purple',
        'Notice'    => 'card__accent-bar--orange',
        'Health'    => 'card__accent-bar--blue',
        'Community' => 'card__accent-bar--green',
        'General'   => 'card__accent-bar--blue',
    ];
@endphp

<section class="page-hero">
    <div class="container">
        <p class="section-label">Announcements</p>
        <div class="page-hero__actions">
            <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <h1 class="page-hero__title">Latest News &amp; Notices</h1>
        <p class="page-hero__subtitle">
            Stay informed with updates from the school office and community.
        </p>
    </div>
</section>

<section class="section announcements">
    <div class="container">
        <div class="announcements__list">
            @forelse($announcements as $ann)
                <article class="card card--announcement" id="announcement-{{ $ann->id }}">
                    <div class="card__accent-bar {{ $accentMap[$ann->category] ?? 'card__accent-bar--blue' }}"></div>
                    <div class="card__body">
                        <div class="card__meta">
                            <span class="badge {{ $ann->category_color }}">{{ $ann->category }}</span>
                            <span class="card__date">{{ $ann->post_date->format('F j, Y') }}</span>
                        </div>
                        @if($ann->is_pinned)
                            <span class="badge badge--dark card__badge-top">📌 Pinned</span>
                        @endif
                        <h2 class="card__title">{{ $ann->title }}</h2>
                        <p class="card__excerpt card__excerpt--full">{!! nl2br(e($ann->body)) !!}</p>
                    </div>
                </article>
            @empty
                <div class="public-empty">
                    <p class="public-empty__title">No announcements yet</p>
                    <p class="public-empty__text">Check back soon for official updates.</p>
                </div>
            @endforelse
        </div>

        @if($announcements->hasPages())
            <div class="public-pagination" role="navigation" aria-label="Announcements pagination">
                @if($announcements->onFirstPage())
                    <span class="public-pagination__btn is-disabled">Previous</span>
                @else
                    <a class="public-pagination__btn" href="{{ $announcements->previousPageUrl() }}">Previous</a>
                @endif

                <span class="public-pagination__meta">
                    Page {{ $announcements->currentPage() }} of {{ $announcements->lastPage() }}
                </span>

                @if($announcements->hasMorePages())
                    <a class="public-pagination__btn" href="{{ $announcements->nextPageUrl() }}">Next</a>
                @else
                    <span class="public-pagination__btn is-disabled">Next</span>
                @endif
            </div>
        @endif
    </div>
</section>

@endsection
