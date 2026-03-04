{{-- Trigger from footer: onclick="openInfoModal('modalCurriculum')" --}}

<div class="info-modal-overlay" id="modalCurriculum" role="dialog" aria-modal="true" aria-labelledby="modalCurriculumTitle">
    <div class="info-modal">

        <div class="info-modal__header">
            <div class="info-modal__header-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div>
                <h2 class="info-modal__title" id="modalCurriculumTitle">Curriculum (DepEd)</h2>
                <p class="info-modal__subtitle">K–12 Basic Education Program</p>
            </div>
            <button class="info-modal__close" onclick="closeInfoModal('modalCurriculum')" aria-label="Close">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="info-modal__body">

            <p class="info-modal__lead">
                Taboc Elementary School follows the <strong>K–12 Basic Education Curriculum</strong> set by the
                Department of Education (DepEd), designed to provide every Filipino child with a quality,
                complete, and relevant education.
            </p>

            <div class="info-modal__section">
                <h3 class="info-modal__section-title">Grade Levels Offered</h3>
                <div class="info-modal__grid">
                    @php
                        $levels = [
                            ['grade'=>'Kindergarten','age'=>'5–6 years old',  'color'=>'#f97316'],
                            ['grade'=>'Grade 1',     'age'=>'6–7 years old',  'color'=>'#1a56db'],
                            ['grade'=>'Grade 2',     'age'=>'7–8 years old',  'color'=>'#7c3aed'],
                            ['grade'=>'Grade 3',     'age'=>'8–9 years old',  'color'=>'#0891b2'],
                            ['grade'=>'Grade 4',     'age'=>'9–10 years old', 'color'=>'#16a34a'],
                            ['grade'=>'Grade 5',     'age'=>'10–11 years old','color'=>'#d97706'],
                            ['grade'=>'Grade 6',     'age'=>'11–12 years old','color'=>'#dc2626'],
                        ];
                    @endphp
                    @foreach($levels as $level)
                    <div class="info-modal__grade-card">
                        <span class="info-modal__grade-dot" style="background:{{ $level['color'] }};"></span>
                        <div>
                            <p class="info-modal__grade-name">{{ $level['grade'] }}</p>
                            <p class="info-modal__grade-age">{{ $level['age'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="info-modal__section">
                <h3 class="info-modal__section-title">Core Learning Areas</h3>
                <div class="info-modal__subjects">
                    @php
                        $subjects = [
                            ['icon'=>'📖','name'=>'Filipino',              'desc'=>'Language, reading & literature'],
                            ['icon'=>'🔤','name'=>'English',               'desc'=>'Communication & literacy'],
                            ['icon'=>'🔢','name'=>'Mathematics',           'desc'=>'Numbers, operations & logic'],
                            ['icon'=>'🔬','name'=>'Science',               'desc'=>'Natural & physical sciences'],
                            ['icon'=>'🌏','name'=>'Araling Panlipunan',    'desc'=>'Social studies & values'],
                            ['icon'=>'🙏','name'=>'Edukasyon sa Pagpapahalaga','desc'=>'Character & values education'],
                            ['icon'=>'🎨','name'=>'MAPEH',                 'desc'=>'Music, Arts, PE & Health'],
                            ['icon'=>'💻','name'=>'EPP / TLE',             'desc'=>'Technology & home economics'],
                        ];
                    @endphp
                    @foreach($subjects as $s)
                    <div class="info-modal__subject-item">
                        <span class="info-modal__subject-icon">{{ $s['icon'] }}</span>
                        <div>
                            <p class="info-modal__subject-name">{{ $s['name'] }}</p>
                            <p class="info-modal__subject-desc">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="info-modal__notice">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Curriculum fully aligned with DepEd's <strong>Most Essential Learning Competencies (MELCs)</strong>.
                Visit the <a href="https://www.deped.gov.ph" target="_blank" rel="noopener" class="info-modal__link">DepEd official website ↗</a></p>
            </div>

        </div>

        <div class="info-modal__footer">
            <a href="https://www.deped.gov.ph" target="_blank" rel="noopener" class="btn btn--primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Visit DepEd Website
            </a>
            <button class="btn btn--ghost" onclick="closeInfoModal('modalCurriculum')">Close</button>
        </div>

    </div>
</div>