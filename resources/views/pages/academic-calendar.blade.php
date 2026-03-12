{{-- pages/academic-calendar.blade.php --}}
@extends('layouts.home')

@section('title', 'Academic Calendar — Taboc Elementary School')
@section('meta_description', 'View the academic calendar for Taboc Elementary School including class schedules, holidays, exams, and important dates.')

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
        <h1 class="page-hero__title">Academic Calendar</h1>
        <p class="page-hero__subtitle">
            Important dates, class opening, holidays, and examination schedules for the school year.
        </p>
    </div>
</section>

<section class="section info-page">
    <div class="container">
        <div class="info-page__content">
            <article class="info-card">
                <div class="info-card__icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="info-card__title">Academic Calendar</h2>
                <div class="info-card__body">
                    {!! nl2br(e($academic_calendar_info)) !!}
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
