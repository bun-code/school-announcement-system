{{-- resources/views/livewire/admin/site-settings-manager.blade.php --}}
<div
    x-data="{ tab: @entangle('activeTab') }"
    x-on:notify.window="
        const t = $event.detail.type;
        const m = $event.detail.message;
        const el = document.getElementById('settings-toast');
        el.textContent = m;
        el.className = 'settings-toast settings-toast--' + t + ' show';
        setTimeout(() => el.classList.remove('show'), 3000);
    "
>

    {{-- Toast --}}
    <div id="settings-toast" class="settings-toast" role="status" aria-live="polite"></div>

    @if ($errors->any())
        <div class="alert alert--danger" style="margin-bottom:var(--space-4);">
            Please fill in all required fields before saving.
        </div>
    @endif

    {{-- Page intro --}}
    <div class="settings-intro animate-fade-up">
        <p>Changes made here are reflected on the public homepage immediately after saving.</p>
    </div>

    {{-- Tab nav --}}
    <div class="settings-tabs animate-fade-up">
        <button class="settings-tab" :class="{ 'active': tab === 'hero' }" @click="tab = 'hero'; $wire.activeTab = 'hero'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Hero Section
        </button>
        <button class="settings-tab" :class="{ 'active': tab === 'stats' }" @click="tab = 'stats'; $wire.activeTab = 'stats'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Stats Banner
        </button>
        <button class="settings-tab" :class="{ 'active': tab === 'school' }" @click="tab = 'school'; $wire.activeTab = 'school'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            School Info
        </button>
        <button class="settings-tab" :class="{ 'active': tab === 'footer' }" @click="tab = 'footer'; $wire.activeTab = 'footer'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Footer Links
        </button>
        <button class="settings-tab" :class="{ 'active': tab === 'directory' }" @click="tab = 'directory'; $wire.activeTab = 'directory'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C6.228 6.228 2 10.456 2 15.5c0 5.046 4.228 9.274 10 9.274s10-4.228 10-9.274c0-5.044-4.228-9.247-10-9.247z"/>
            </svg>
            School Directory
        </button>
        <button class="settings-tab" :class="{ 'active': tab === 'ticker' }" @click="tab = 'ticker'; $wire.activeTab = 'ticker'">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            Ticker
        </button>
    </div>

    {{-- â”€â”€ TAB: HERO â”€â”€ --}}
    <div x-show="tab === 'hero'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">Hero Section</p>
                    <p class="settings-panel__subtitle">Edit the main banner text displayed at the top of the homepage.</p>
                </div>
                {{-- Live preview badge --}}
                <span class="badge badge--green">Live on Homepage</span>
            </div>

            <div class="settings-panel__body">

                {{-- Preview --}}
                <div class="settings-preview">
                    <p class="settings-preview__label">Preview</p>
                    <div class="settings-preview__hero">
                        <div class="settings-preview__pill">
                            <span class="settings-preview__pill-dot"></span>
                            <span x-text="$wire.hero_pill || 'Enrollment pill text'"></span>
                        </div>
                        <h2 class="settings-preview__title">
                            <span x-text="$wire.hero_title_line1 || 'Line 1'"></span><br/>
                            <span class="settings-preview__accent" x-text="$wire.hero_title_line2 || 'Line 2 (accent)'"></span><br/>
                            <span x-text="$wire.hero_title_line3 || 'Line 3'"></span>
                        </h2>
                        <p class="settings-preview__desc" x-text="$wire.hero_description || 'Description text...'"></p>
                        <div class="settings-preview__btns">
                            <span class="settings-preview__btn settings-preview__btn--primary" x-text="$wire.hero_cta_primary || 'Primary CTA'"></span>
                            <span class="settings-preview__btn settings-preview__btn--ghost" x-text="$wire.hero_cta_secondary || 'Secondary CTA'"></span>
                        </div>
                    </div>
                </div>

                <div class="settings-divider"></div>

                {{-- Fields --}}
                <div class="settings-grid">

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Enrollment Pill Text</label>
                        <input type="text" wire:model.live="hero_pill" class="settings-input"
                               placeholder="S.Y. 2025-2026 Enrollment Now Open" maxlength="100"/>
                        <p class="settings-hint">The small pill/badge above the hero title</p>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Title - Line 1</label>
                        <input type="text" wire:model.live="hero_title_line1" class="settings-input"
                               placeholder="Where Every Child" maxlength="80"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Title - Line 2 <span class="settings-label__accent">(gradient accent)</span></label>
                        <input type="text" wire:model.live="hero_title_line2" class="settings-input"
                               placeholder="Learns, Grows" maxlength="80"/>
                    </div>

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Title - Line 3</label>
                        <input type="text" wire:model.live="hero_title_line3" class="settings-input"
                               placeholder="& Thrives" maxlength="80"/>
                    </div>

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Description</label>
                        <textarea wire:model.live="hero_description" class="settings-input settings-textarea"
                                  placeholder="School description..." maxlength="400" rows="3"></textarea>
                        <p class="settings-hint">Shown below the hero title. Max 400 characters.</p>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Primary Button Text</label>
                        <input type="text" wire:model.live="hero_cta_primary" class="settings-input"
                               placeholder="Latest Updates" maxlength="40"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Secondary Button Text</label>
                        <input type="text" wire:model.live="hero_cta_secondary" class="settings-input"
                               placeholder="About Our School" maxlength="40"/>
                    </div>

                </div>
            </div>

            <div class="settings-panel__footer">
                <button wire:click="saveHero" wire:loading.attr="disabled" class="btn btn--primary">
                    <span wire:loading.remove wire:target="saveHero">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Hero Section
                    </span>
                    <span wire:loading wire:target="saveHero">Saving...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- â”€â”€ TAB: STATS â”€â”€ --}}
    <div x-show="tab === 'stats'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">Stats Banner</p>
                    <p class="settings-panel__subtitle">Numbers shown in the banner strip and the homepage hero stats.</p>
                </div>
                <span class="badge badge--green">Live on Homepage</span>
            </div>

            <div class="settings-panel__body">

                {{-- Preview --}}
                <div class="settings-preview">
                    <p class="settings-preview__label">Preview</p>
                    <div class="settings-preview__stats">
                        <div class="settings-preview__stat">
                            <p class="settings-preview__stat-value" x-text="$wire.stats_students || '500+'"></p>
                            <p class="settings-preview__stat-label">Students</p>
                        </div>
                        <div class="settings-preview__stat">
                            <p class="settings-preview__stat-value" x-text="$wire.stats_teachers || '30+'"></p>
                            <p class="settings-preview__stat-label">Teachers</p>
                        </div>
                        <div class="settings-preview__stat">
                            <p class="settings-preview__stat-value" x-text="$wire.stats_years || '20+'"></p>
                            <p class="settings-preview__stat-label">Years</p>
                        </div>
                        <div class="settings-preview__stat">
                            <p class="settings-preview__stat-value" x-text="$wire.stats_admins || '2'"></p>
                            <p class="settings-preview__stat-label">Admins</p>
                        </div>
                    </div>
                </div>

                <div class="settings-divider"></div>

                <div class="settings-grid">
                    <div class="settings-field">
                        <label class="settings-label">Total Students</label>
                        <input type="text" wire:model.live="stats_students" class="settings-input"
                               placeholder="500+" maxlength="20"/>
                        <p class="settings-hint">e.g. 500+ or 1,200</p>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Total Teachers</label>
                        <input type="text" wire:model.live="stats_teachers" class="settings-input"
                               placeholder="30+" maxlength="20"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Years of Service</label>
                        <input type="text" wire:model.live="stats_years" class="settings-input"
                               placeholder="20+" maxlength="20"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Total Admins</label>
                        <input type="text" wire:model.live="stats_admins" class="settings-input"
                               placeholder="2" maxlength="20"/>
                    </div>
                </div>
            </div>

            <div class="settings-panel__footer">
                <button wire:click="saveStats" wire:loading.attr="disabled" class="btn btn--primary">
                    <span wire:loading.remove wire:target="saveStats">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Stats
                    </span>
                    <span wire:loading wire:target="saveStats">Saving...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- â”€â”€ TAB: SCHOOL INFO â”€â”€ --}}
    <div x-show="tab === 'school'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">School Information</p>
                    <p class="settings-panel__subtitle">Displayed in the About section and Contact area of the homepage.</p>
                </div>
                <span class="badge badge--green">Live on Homepage</span>
            </div>

            <div class="settings-panel__body">
                <div class="settings-grid">
                    <div class="settings-field">
                        <label class="settings-label">School Head Name</label>
                        <input type="text" wire:model="school_head" class="settings-input"
                               placeholder="Mrs. [Principal Name]" maxlength="100"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">School Head Title / Position</label>
                        <input type="text" wire:model="school_head_title" class="settings-input"
                               placeholder="Principal I" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Class Hours</label>
                        <input type="text" wire:model="class_hours" class="settings-input"
                               placeholder="7:30 AM - 5:00 PM" maxlength="60"/>
                        <p class="settings-hint">Displayed in the About info grid</p>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">School Location</label>
                        <input type="text" wire:model="school_location" class="settings-input"
                               placeholder="Taboc, Philippines" maxlength="100"/>
                        <p class="settings-hint">Used in About section and Contact area</p>
                    </div>
                </div>
            </div>

            <div class="settings-panel__footer">
                <button wire:click="saveSchoolInfo" wire:loading.attr="disabled" class="btn btn--primary">
                    <span wire:loading.remove wire:target="saveSchoolInfo">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save School Info
                    </span>
                    <span wire:loading wire:target="saveSchoolInfo">Saving...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- â”€â”€ TAB: TICKER â”€â”€ --}}
    {{-- --- TAB: FOOTER LINKS --- --}}
    <div x-show="tab === 'footer'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">Footer Links</p>
                    <p class="settings-panel__subtitle">Update the Quick Links shown in the public site footer.</p>
                </div>
                <span class="badge badge--green">Live on Homepage</span>
            </div>

            <div class="settings-panel__body">
                <div class="settings-grid">
                    <div class="settings-field">
                        <label class="settings-label">Link 1 Label</label>
                        <input type="text" wire:model="footer_link_1_label" class="settings-input"
                               placeholder="Home" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Link 1 URL</label>
                        <input type="text" wire:model="footer_link_1_url" class="settings-input"
                               placeholder="/" maxlength="255"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Link 2 Label</label>
                        <input type="text" wire:model="footer_link_2_label" class="settings-input"
                               placeholder="Announcements" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Link 2 URL</label>
                        <input type="text" wire:model="footer_link_2_url" class="settings-input"
                               placeholder="/#announcements" maxlength="255"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Link 3 Label</label>
                        <input type="text" wire:model="footer_link_3_label" class="settings-input"
                               placeholder="Events" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Link 3 URL</label>
                        <input type="text" wire:model="footer_link_3_url" class="settings-input"
                               placeholder="/#events" maxlength="255"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Link 4 Label</label>
                        <input type="text" wire:model="footer_link_4_label" class="settings-input"
                               placeholder="Achievements" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Link 4 URL</label>
                        <input type="text" wire:model="footer_link_4_url" class="settings-input"
                               placeholder="/#achievements" maxlength="255"/>
                    </div>

                    <div class="settings-field">
                        <label class="settings-label">Link 5 Label</label>
                        <input type="text" wire:model="footer_link_5_label" class="settings-input"
                               placeholder="About Us" maxlength="60"/>
                    </div>
                    <div class="settings-field">
                        <label class="settings-label">Link 5 URL</label>
                        <input type="text" wire:model="footer_link_5_url" class="settings-input"
                               placeholder="/about" maxlength="255"/>
                    </div>
                </div>
            </div>

            <div class="settings-panel__footer">
                <button wire:click="saveFooterLinks" wire:loading.attr="disabled" class="btn btn--primary">
                    <span wire:loading.remove wire:target="saveFooterLinks">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Footer Links
                    </span>
                    <span wire:loading wire:target="saveFooterLinks">Saving...</span>
                </button>
            </div>
        </div>
    </div>

    <div x-show="tab === 'ticker'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">Announcement Ticker</p>
                    <p class="settings-panel__subtitle">The scrolling banner at the top of the homepage. Automatically pulls from your published announcements.</p>
                </div>
                <span class="badge badge--blue">Auto-managed</span>
            </div>

            <div class="settings-panel__body">

                <div class="settings-info-box">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:20px;height:20px;flex-shrink:0;margin-top:2px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p><strong>The ticker is automatic.</strong> It scrolls through all published announcement titles in real time.</p>
                        <p style="margin-top:6px;">To control what appears in the ticker, go to <a href="{{ route('admin.announcements.index') }}" wire:navigate>Announcements</a> and publish or unpublish items there.</p>
                    </div>
                </div>

                {{-- Live preview of current ticker items --}}
                @php
                    $tickerItems = \App\Models\Announcement::published()->latest('post_date')->take(8)->pluck('title');
                @endphp

                <div style="margin-top: var(--space-6);">
                    <p class="settings-label" style="margin-bottom:var(--space-3);">Currently showing in ticker ({{ $tickerItems->count() }} items)</p>

                    @forelse($tickerItems as $item)
                    <div class="ticker-preview-item">
                        <span class="ticker-preview-item__dot"></span>
                        <span>{{ $item }}</span>
                    </div>
                    @empty
                    <div class="settings-info-box" style="background:var(--color-warning-light);border-color:var(--color-warning);">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:20px;height:20px;flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p><strong>No published announcements yet.</strong> The ticker will be empty until you publish at least one announcement.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- TAB: SCHOOL DIRECTORY --}}
    <div x-show="tab === 'directory'" x-transition>
        <div class="settings-panel animate-fade-up">
            <div class="settings-panel__header">
                <div>
                    <p class="settings-panel__title">School Directory Information</p>
                    <p class="settings-panel__subtitle">Edit content for pages like Enrollment, Academic Calendar, Curriculum, and School Policies.</p>
                </div>
                <span class="badge badge--green">Live on Public Site</span>
            </div>

            <div class="settings-panel__body">
                <div class="settings-grid">
                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Enrollment Information</label>
                        <textarea wire:model="enrollment_info" class="settings-input settings-textarea"
                                  placeholder="Visit the enrollment office or call us..." maxlength="2000" rows="5"></textarea>
                        <p class="settings-hint">Shown on the Enrollment page. Max 2000 characters.</p>
                    </div>

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Academic Calendar Information</label>
                        <textarea wire:model="academic_calendar_info" class="settings-input settings-textarea"
                                  placeholder="The academic calendar outlines all important dates..." maxlength="2000" rows="5"></textarea>
                        <p class="settings-hint">Shown on the Academic Calendar page. Max 2000 characters.</p>
                    </div>

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">Curriculum (DepEd) Information</label>
                        <textarea wire:model="curriculum_info" class="settings-input settings-textarea"
                                  placeholder="Our curriculum is guided by the DepEd Framework..." maxlength="2000" rows="5"></textarea>
                        <p class="settings-hint">Shown on the Curriculum page. Max 2000 characters.</p>
                    </div>

                    <div class="settings-field settings-field--full">
                        <label class="settings-label">School Policies Information</label>
                        <textarea wire:model="school_policies_info" class="settings-input settings-textarea"
                                  placeholder="Our school policies are designed to create a safe..." maxlength="2000" rows="5"></textarea>
                        <p class="settings-hint">Shown on the School Policies page. Max 2000 characters.</p>
                    </div>
                </div>
            </div>

            <div class="settings-panel__footer">
                <button wire:click="saveSchoolDirectory" wire:loading.attr="disabled" class="btn btn--primary">
                    <span wire:loading.remove wire:target="saveSchoolDirectory">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:16px;height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save School Directory Info
                    </span>
                    <span wire:loading wire:target="saveSchoolDirectory">Saving...</span>
                </button>
            </div>
        </div>
    </div>

</div>
