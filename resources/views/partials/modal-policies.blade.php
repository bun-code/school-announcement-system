{{-- Trigger from footer: onclick="openInfoModal('modalPolicies')" --}}

<div class="info-modal-overlay" id="modalPolicies" role="dialog" aria-modal="true" aria-labelledby="modalPoliciesTitle">
    <div class="info-modal">

        <div class="info-modal__header">
            <div class="info-modal__header-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="info-modal__title" id="modalPoliciesTitle">School Policies</h2>
                <p class="info-modal__subtitle">Guidelines for a safe and respectful learning environment</p>
            </div>
            <button class="info-modal__close" onclick="closeInfoModal('modalPolicies')" aria-label="Close">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="info-modal__body">
            <p class="info-modal__lead">
                These policies help keep our campus safe, organized, and focused on learning. For any
                questions or clarifications, please contact the school office.
            </p>

            <div class="info-modal__policy-block">
                <div class="info-modal__policy-header">
                    <div class="info-modal__policy-icon" style="background:#e0f2fe;color:#0284c7;">🕒</div>
                    <div class="info-modal__policy-title">Attendance &amp; Punctuality</div>
                </div>
                <div class="info-modal__policy-list">
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#0284c7;"></span>
                        Students are expected to attend classes regularly and arrive on time.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#0284c7;"></span>
                        Parents/guardians should inform the adviser for absences.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#0284c7;"></span>
                        Three consecutive absences require a note or confirmation.
                    </div>
                </div>
            </div>

            <div class="info-modal__policy-block">
                <div class="info-modal__policy-header">
                    <div class="info-modal__policy-icon" style="background:#ede9fe;color:#7c3aed;">🎓</div>
                    <div class="info-modal__policy-title">Uniform &amp; Appearance</div>
                </div>
                <div class="info-modal__policy-list">
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#7c3aed;"></span>
                        Proper uniform is required on school days unless announced otherwise.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#7c3aed;"></span>
                        Hair should be neat and appropriate for school.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#7c3aed;"></span>
                        ID lanyards should be worn inside the campus.
                    </div>
                </div>
            </div>

            <div class="info-modal__policy-block">
                <div class="info-modal__policy-header">
                    <div class="info-modal__policy-icon" style="background:#dcfce7;color:#16a34a;">🛡️</div>
                    <div class="info-modal__policy-title">Safety &amp; Conduct</div>
                </div>
                <div class="info-modal__policy-list">
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#16a34a;"></span>
                        Respectful behavior toward classmates, teachers, and staff is expected.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#16a34a;"></span>
                        Bullying, harassment, and vandalism are strictly prohibited.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#16a34a;"></span>
                        Always follow safety instructions during drills and school activities.
                    </div>
                </div>
            </div>

            <div class="info-modal__policy-block">
                <div class="info-modal__policy-header">
                    <div class="info-modal__policy-icon" style="background:#fef3c7;color:#d97706;">📣</div>
                    <div class="info-modal__policy-title">Communication &amp; Requests</div>
                </div>
                <div class="info-modal__policy-list">
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#d97706;"></span>
                        School announcements will be posted on the official page and bulletin boards.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#d97706;"></span>
                        Requests for certificates should be filed at the office during working hours.
                    </div>
                    <div class="info-modal__policy-item">
                        <span class="info-modal__policy-dot" style="background:#d97706;"></span>
                        Parent conferences can be scheduled through the adviser.
                    </div>
                </div>
            </div>

            <div class="info-modal__notice">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>
                    Policies may be updated during the school year. For official clarifications,
                    please contact the school office.
                </p>
            </div>
        </div>

        <div class="info-modal__footer">
            <button class="btn btn--secondary" onclick="closeInfoModal('modalPolicies')">Close</button>
        </div>

    </div>
</div>
