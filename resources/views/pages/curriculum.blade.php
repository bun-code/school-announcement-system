{{-- pages/curriculum.blade.php --}}
@extends('layouts.home')

@section('title', 'Curriculum — Taboc Elementary School')
@section('meta_description', 'Learn about our DepEd-guided curriculum and educational programs at Taboc Elementary School.')

@section('page_content')

<section class="page-hero">
    <div class="container">
        <p class="section-label">School Info</p>
        <div class="page-hero__actions">
            <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <h1 class="page-hero__title">Curriculum (DepEd)</h1>
        <p class="page-hero__subtitle">
            Our comprehensive, culturally-relevant education grounded in Filipino values and excellence.
        </p>
    </div>
</section>

<section class="section info-page">
    <div class="container">
        <div class="info-page__content">
            <article class="info-card">
                <div class="info-card__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C6.228 6.228 2 10.456 2 15.5c0 5.046 4.228 9.274 10 9.274s10-4.228 10-9.274c0-5.044-4.228-9.247-10-9.247z"/>
                    </svg>
                </div>
                <h2 class="info-card__title">Curriculum (DepEd)</h2>
                <div class="info-card__body">
                    {!! nl2br(e($curriculum_info)) !!}
                </div>
            </article>
        </div>
    </div>
</section>

<style>
    .info-page {
        padding: 60px 0;
    }

    .info-page__content {
        max-width: 800px;
        margin: 0 auto;
    }

    .info-card {
        background: #f9fafb;
        border-radius: 12px;
        padding: 40px;
        border: 1px solid #e5e7eb;
    }

    .info-card__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        margin-bottom: 24px;
        color: white;
    }

    .info-card__icon svg {
        width: 32px;
        height: 32px;
    }

    .info-card__title {
        font-size: 26px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
    }

    .info-card__body {
        font-size: 16px;
        color: #4b5563;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .info-page {
            padding: 40px 0;
        }

        .info-card {
            padding: 24px;
        }

        .info-card__title {
            font-size: 22px;
        }
    }
</style>

@endsection
