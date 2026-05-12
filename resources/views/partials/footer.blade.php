{{--
============================================================
SECTION: Footer
FILE: resources/views/partials/footer.blade.php
INCLUDE: @include('partials.footer') in your layout
CSS FILE: footer.css  (link in your layout head)
============================================================
--}}

<footer class="st-footer">

    {{-- ── Package Links ── --}}
    <div class="st-footer-links-section">
        <div class="st-footer-container">

            {{-- Tab Nav --}}
            <div class="st-footer-tabs" role="tablist">
                <button class="st-footer-tab active" role="tab" aria-selected="true"
                    data-target="tab-india">India Packages</button>
                <button class="st-footer-tab" role="tab" aria-selected="false"
                    data-target="tab-international">International Packages</button>
                <button class="st-footer-tab" role="tab" aria-selected="false"
                    data-target="tab-honeymoon">Honeymoon Packages</button>
            </div>

            <div class="st-footer-tab-divider"></div>

            {{-- India Packages --}}
            <div class="st-footer-tab-panel active" id="tab-india" role="tabpanel">
                <div class="st-footer-link-grid">
                    <a href="#">Ladakh Tour Packages</a>
                    <a href="#">Spiti Tour Packages</a>
                    <a href="#">Kashmir Tour Packages</a>
                    <a href="#">Rajasthan Tour Packages</a>
                    <a href="#">Kerala Tour Packages</a>
                    <a href="#">Andaman Tour Packages</a>
                    <a href="#">Sikkim Tour Packages</a>
                    <a href="#">Darjeeling Tour Packages</a>
                    <a href="#">Meghalaya Tour Packages</a>
                    <a href="#">North East Tour Packages</a>
                    <a href="#">Arunachal Tour Packages</a>
                    <a href="#">Assam Tour Packages</a>
                    <a href="#">Himachal Tour Packages</a>
                    <a href="#">Uttarakhand Tour Packages</a>
                    <a href="#">Manali Tour Packages</a>
                    <a href="#">Jaisalmer Tour Packages</a>
                    <a href="#">Golden Triangle Tour Packages</a>
                    <a href="#">Udaipur Tour Packages</a>
                    <a href="#">Wayanad Tour Packages</a>
                    <a href="#">Munnar Tour Packages</a>
                    <a href="#">Shimla Tour Packages</a>
                    <a href="#">Mussoorie Tour Packages</a>
                    <a href="#">Jim Corbett Tour Packages</a>
                    <a href="#">Srinagar Tour Packages</a>
                    <a href="#">Alleppey Tour Packages</a>
                </div>
            </div>

            {{-- International Packages --}}
            <div class="st-footer-tab-panel" id="tab-international" role="tabpanel">
                <div class="st-footer-link-grid">
                    <a href="#">Bali Tour Packages</a>
                    <a href="#">Dubai Tour Packages</a>
                    <a href="#">Thailand Tour Packages</a>
                    <a href="#">Maldives Tour Packages</a>
                    <a href="#">Singapore Tour Packages</a>
                    <a href="#">Europe Tour Packages</a>
                    <a href="#">Malaysia Tour Packages</a>
                    <a href="#">Sri Lanka Tour Packages</a>
                    <a href="#">Nepal Tour Packages</a>
                    <a href="#">Bhutan Tour Packages</a>
                    <a href="#">Vietnam Tour Packages</a>
                    <a href="#">Japan Tour Packages</a>
                    <a href="#">Mauritius Tour Packages</a>
                    <a href="#">Australia Tour Packages</a>
                    <a href="#">New Zealand Tour Packages</a>
                    <a href="#">Canada Tour Packages</a>
                    <a href="#">USA Tour Packages</a>
                    <a href="#">Turkey Tour Packages</a>
                    <a href="#">Egypt Tour Packages</a>
                    <a href="#">South Africa Tour Packages</a>
                </div>
            </div>

            {{-- Honeymoon Packages --}}
            <div class="st-footer-tab-panel" id="tab-honeymoon" role="tabpanel">
                <div class="st-footer-link-grid">
                    <a href="#">Maldives Honeymoon Packages</a>
                    <a href="#">Bali Honeymoon Packages</a>
                    <a href="#">Kashmir Honeymoon Packages</a>
                    <a href="#">Kerala Honeymoon Packages</a>
                    <a href="#">Shimla Honeymoon Packages</a>
                    <a href="#">Manali Honeymoon Packages</a>
                    <a href="#">Goa Honeymoon Packages</a>
                    <a href="#">Andaman Honeymoon Packages</a>
                    <a href="#">Mauritius Honeymoon Packages</a>
                    <a href="#">Thailand Honeymoon Packages</a>
                    <a href="#">Singapore Honeymoon Packages</a>
                    <a href="#">Dubai Honeymoon Packages</a>
                    <a href="#">Europe Honeymoon Packages</a>
                    <a href="#">Switzerland Honeymoon Packages</a>
                    <a href="#">Paris Honeymoon Packages</a>
                </div>
            </div>

        </div>
    </div>

    {{-- ── Main Footer Body ── --}}
    <div class="st-footer-body">
        <div class="st-footer-container">

            <div class="st-footer-divider"></div>

            <div class="st-footer-cols">

                {{-- About --}}
                <div class="st-footer-col">
                    <h4 class="st-footer-col-title">About SHABDD</h4>
                    <ul class="st-footer-col-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">SHABDD Reviews</a></li>
                        <li><a href="#">News</a></li>
                        <li>
                            <a href="#" class="st-footer-fraud-link">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Beware Of Frauds
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Policies --}}
                <div class="st-footer-col">
                    <h4 class="st-footer-col-title">Policies</h4>
                    <ul class="st-footer-col-links">
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policies</a></li>
                        <li><a href="#">Copyright Policies</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div class="st-footer-col">
                    <h4 class="st-footer-col-title">Contact Us</h4>
                    <ul class="st-footer-col-links">
                        <li>
                            <a href="mailto:support@shabdd.com" class="st-footer-email-link">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="2" y="4" width="20" height="16" rx="3" stroke="currentColor" stroke-width="1.7"/>
                                    <path d="M2 7l10 7 10-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                                support@shabdd.com
                            </a>
                        </li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Sitemap</a></li>
                        <li><a href="#">Partner With SHABDD</a></li>
                        <li><a href="#">Destination Marketing</a></li>
                    </ul>
                </div>

                {{-- Social --}}
                <div class="st-footer-col">
                    <h4 class="st-footer-col-title">Social</h4>
                    <ul class="st-footer-col-links st-footer-social-links">

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- Facebook --}}
                                <span class="st-social-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.6"/>
                                        <path d="M15 8h-1.5A1.5 1.5 0 0012 9.5V11h3l-.5 3H12v7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                Facebook
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- Instagram --}}
                                <span class="st-social-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.6"/>
                                        <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.6"/>
                                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>
                                    </svg>
                                </span>
                                Instagram
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- X / Twitter --}}
                                <span class="st-social-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </span>
                                X.com
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- LinkedIn --}}
                                <span class="st-social-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="2" y="2" width="20" height="20" rx="4" stroke="currentColor" stroke-width="1.6"/>
                                        <path d="M7 10v7M7 7v.01M11 17v-4a2 2 0 014 0v4M11 10v7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                Linkedin
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- YouTube --}}
                                <span class="st-social-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="2" y="5" width="20" height="14" rx="4" stroke="currentColor" stroke-width="1.6"/>
                                        <path d="M10 9l5 3-5 3V9z" fill="currentColor"/>
                                    </svg>
                                </span>
                                Youtube
                            </a>
                        </li>

                    </ul>
                </div>

            </div>{{-- /st-footer-cols --}}

        </div>
    </div>

    {{-- ── Bottom Bar ── --}}
    <div class="st-footer-bottom">
        <div class="st-footer-container">
            <div class="st-footer-divider"></div>
            <div class="st-footer-bottom-inner">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="st-footer-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="SHABDD" class="st-footer-logo">
                </a>

                {{-- Copyright --}}
                <p class="st-footer-copy">
                    &copy; {{ date('Y') }} SHABDD.com All rights reserved.
                </p>

            </div>
        </div>
    </div>

</footer>

{{-- ── Tab JS ── --}}
<script>
(function () {
    const tabs   = document.querySelectorAll('.st-footer-tab');
    const panels = document.querySelectorAll('.st-footer-tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.target;

            tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
            panels.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            document.getElementById(target)?.classList.add('active');
        });
    });
})();
</script>