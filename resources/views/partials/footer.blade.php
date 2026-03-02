{{-- partials/footer.blade.php --}}
{{-- Included automatically via app.blade.php --}}

<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="footer__grid">

            {{-- ── Brand Column ── --}}
            <div>
                <div class="footer__brand-logo">
                    <div class="footer__brand-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3L2 9l10 6 10-6-10-6zM2 17l10 6 10-6M2 13l10 6 10-6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="footer__brand-name">Taboc Elementary</p>
                        <p class="footer__brand-sub">School</p>
                    </div>
                </div>

                <p class="footer__tagline">
                    Nurturing every learner's potential through quality, inclusive education grounded in Filipino values and excellence.
                </p>

                <div class="footer__social" aria-label="Social media links">
                    <a href="#" class="footer__social-btn" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="#" class="footer__social-btn" aria-label="Twitter / X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>
                    <a href="#" class="footer__social-btn" aria-label="Email">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ── Quick Links ── --}}
            <div>
                <p class="footer__col-title">Quick Links</p>
                <nav class="footer__links" aria-label="Footer quick links">
                    <a href="{{ url('/') }}"              class="footer__link">Home</a>
                    <a href="{{ url('/#announcements') }}" class="footer__link">Announcements</a>
                    <a href="{{ url('/#events') }}"        class="footer__link">Events</a>
                    <a href="{{ url('/#achievements') }}"  class="footer__link">Achievements</a>
                    <a href="{{ url('/about') }}"          class="footer__link">About Us</a>
                </nav>
            </div>

            {{-- ── School Info ── --}}
            <div>
                <p class="footer__col-title">School Info</p>
                <div class="footer__links">
                    <span class="footer__link">Enrollment</span>
                    <span class="footer__link">Academic Calendar</span>
                    <span class="footer__link">Curriculum (DepEd)</span>
                    <span class="footer__link">Faculty &amp; Staff</span>
                    <span class="footer__link">School Policies</span>
                </div>
            </div>

            {{-- ── Contact ── --}}
            <div>
                <p class="footer__col-title">Contact</p>

                <div class="footer__contact-item">
                    <div class="footer__contact-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="footer__contact-label">Address</p>
                        <p class="footer__contact-value">Taboc, Philippines</p>
                    </div>
                </div>

                <div class="footer__contact-item">
                    <div class="footer__contact-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="footer__contact-label">Email</p>
                        <p class="footer__contact-value">taboc.es@deped.gov.ph</p>
                    </div>
                </div>

                <div class="footer__contact-item">
                    <div class="footer__contact-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="footer__contact-label">Office Hours</p>
                        <p class="footer__contact-value">Mon–Fri, 7:30 AM – 5:00 PM</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Bottom Bar ── --}}
        <div class="footer__bottom">
            <p class="footer__copyright">
                &copy; {{ date('Y') }} Taboc Elementary School. All rights reserved. &bull; DepEd Philippines
            </p>
            <div class="footer__bottom-links">
                <a href="#" class="footer__bottom-link">Privacy Policy</a>
                <a href="#" class="footer__bottom-link">Terms of Use</a>
                <a href="#" class="footer__bottom-link">Sitemap</a>
            </div>
        </div>

    </div>
</footer>