{{-- pages/faculty.blade.php --}}
@extends('layouts.home')

@section('title', 'Faculty & Staff — Taboc Elementary School')
@section('meta_description', 'Meet the dedicated faculty and staff members of Taboc Elementary School.')

@section('page_content')

<section class="page-hero">
    <div class="container">
        <p class="section-label">Faculty & Staff</p>
        <div class="page-hero__actions">
            <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <h1 class="page-hero__title">Faculty & Staff Directory</h1>
        <p class="page-hero__subtitle">
            Get to know the dedicated educators and professionals serving Taboc Elementary School.
        </p>
    </div>
</section>

@php
    $typeLabels = [
        'teaching' => 'Teaching Staff',
        'non-teaching' => 'Support Staff',
        'administrative' => 'Administrative',
    ];
    
    $typeColors = [
        'teaching' => 'badge--blue',
        'non-teaching' => 'badge--gray',
        'administrative' => 'badge--purple',
    ];
@endphp

<section class="section faculty">
    <div class="container">

        {{-- Teaching Staff --}}
        @if($teaching->count() > 0)
            <div class="faculty__section">
                <h2 class="faculty__section-title">
                    <svg class="faculty__section-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-12c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                    </svg>
                    Teaching Staff
                </h2>
                <div class="faculty__grid">
                    @foreach($teaching as $staff)
                        <article class="faculty__card">
                            <div class="faculty__photo-wrapper">
                                @if($staff->photo_url)
                                    <img 
                                        src="{{ $staff->photo_url }}" 
                                        alt="{{ $staff->full_name }}"
                                        class="faculty__photo"
                                    />
                                @else
                                    <div class="faculty__photo faculty__photo--placeholder">
                                        <span class="faculty__initials">{{ $staff->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="faculty__body">
                                <h3 class="faculty__name">{{ $staff->full_name }}</h3>
                                @if($staff->subject)
                                    <p class="faculty__detail">
                                        <span class="faculty__label">Subject:</span>
                                        <span>{{ $staff->subject }}</span>
                                    </p>
                                @endif
                                @if($staff->grade_handled)
                                    <p class="faculty__detail">
                                        <span class="faculty__label">Grade:</span>
                                        <span>{{ $staff->grade_handled }}</span>
                                    </p>
                                @endif
                                @if($staff->position)
                                    <p class="faculty__detail">
                                        <span class="faculty__label">Position:</span>
                                        <span>{{ $staff->position }}</span>
                                    </p>
                                @endif
                                <div class="faculty__contact">
                                    @if($staff->email)
                                        <a href="mailto:{{ $staff->email }}" class="faculty__contact-link" title="Email">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Email
                                        </a>
                                    @endif
                                    @if($staff->phone)
                                        <a href="tel:{{ $staff->phone }}" class="faculty__contact-link" title="Phone">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            Call
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Support Staff --}}
        @if($nonTeaching->count() > 0)
            <div class="faculty__section">
                <h2 class="faculty__section-title">
                    <svg class="faculty__section-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-12c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                    </svg>
                    Support Staff
                </h2>
                <div class="faculty__grid">
                    @foreach($nonTeaching as $staff)
                        <article class="faculty__card">
                            <div class="faculty__photo-wrapper">
                                @if($staff->photo_url)
                                    <img 
                                        src="{{ $staff->photo_url }}" 
                                        alt="{{ $staff->full_name }}"
                                        class="faculty__photo"
                                    />
                                @else
                                    <div class="faculty__photo faculty__photo--placeholder">
                                        <span class="faculty__initials">{{ $staff->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="faculty__body">
                                <h3 class="faculty__name">{{ $staff->full_name }}</h3>
                                @if($staff->position)
                                    <p class="faculty__detail">
                                        <span class="faculty__label">Position:</span>
                                        <span>{{ $staff->position }}</span>
                                    </p>
                                @endif
                                <div class="faculty__contact">
                                    @if($staff->email)
                                        <a href="mailto:{{ $staff->email }}" class="faculty__contact-link" title="Email">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Email
                                        </a>
                                    @endif
                                    @if($staff->phone)
                                        <a href="tel:{{ $staff->phone }}" class="faculty__contact-link" title="Phone">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            Call
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Administrative Staff --}}
        @if($administrative->count() > 0)
            <div class="faculty__section">
                <h2 class="faculty__section-title">
                    <svg class="faculty__section-icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-12c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/>
                    </svg>
                    Administration
                </h2>
                <div class="faculty__grid">
                    @foreach($administrative as $staff)
                        <article class="faculty__card">
                            <div class="faculty__photo-wrapper">
                                @if($staff->photo_url)
                                    <img 
                                        src="{{ $staff->photo_url }}" 
                                        alt="{{ $staff->full_name }}"
                                        class="faculty__photo"
                                    />
                                @else
                                    <div class="faculty__photo faculty__photo--placeholder">
                                        <span class="faculty__initials">{{ $staff->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="faculty__body">
                                <h3 class="faculty__name">{{ $staff->full_name }}</h3>
                                @if($staff->position)
                                    <p class="faculty__detail">
                                        <span class="faculty__label">Position:</span>
                                        <span>{{ $staff->position }}</span>
                                    </p>
                                @endif
                                <div class="faculty__contact">
                                    @if($staff->email)
                                        <a href="mailto:{{ $staff->email }}" class="faculty__contact-link" title="Email">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            Email
                                        </a>
                                    @endif
                                    @if($staff->phone)
                                        <a href="tel:{{ $staff->phone }}" class="faculty__contact-link" title="Phone">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            Call
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- No Staff Message --}}
        @if($teaching->count() === 0 && $nonTeaching->count() === 0 && $administrative->count() === 0)
            <div class="public-empty">
                <p class="public-empty__title">No faculty members published yet</p>
                <p class="public-empty__text">Staff directory will be available soon.</p>
            </div>
        @endif

    </div>
</section>

<style>
    .faculty {
        padding: 60px 0;
    }

    .faculty__section {
        margin-bottom: 60px;
    }

    .faculty__section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #1a1a1a;
    }

    .faculty__section-icon {
        width: 28px;
        height: 28px;
        color: #3b82f6;
    }

    .faculty__grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .faculty__card {
        background: #f9fafb;
        border-radius: 8px;
        padding: 24px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .faculty__card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-4px);
    }

    .faculty__photo-wrapper {
        margin-bottom: 16px;
    }

    .faculty__photo {
        width: 100%;
        height: 280px;
        object-fit: cover;
        border-radius: 6px;
        display: block;
    }

    .faculty__photo--placeholder {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .faculty__initials {
        font-size: 48px;
        font-weight: 700;
        color: white;
    }

    .faculty__body {
        flex: 1;
    }

    .faculty__name {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }

    .faculty__detail {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .faculty__label {
        font-weight: 600;
        color: #374151;
    }

    .faculty__contact {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .faculty__contact-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 600;
        color: #3b82f6;
        background: #eff6ff;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .faculty__contact-link:hover {
        background: #3b82f6;
        color: white;
    }

    .faculty__contact-link svg {
        width: 16px;
        height: 16px;
    }

    @media (max-width: 768px) {
        .faculty__grid {
            grid-template-columns: 1fr;
        }

        .faculty__section-title {
            font-size: 20px;
        }
    }
</style>

@endsection
