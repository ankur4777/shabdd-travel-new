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
                    data-target="tab-domestic">Domestic Destinations</button>
                <button class="st-footer-tab" role="tab" aria-selected="false"
                    data-target="tab-international">International Destinations</button>
                @foreach(($footerTravelStyleTabs ?? []) as $styleTab)
                    <button class="st-footer-tab" role="tab" aria-selected="false"
                        data-target="tab-style-{{ $styleTab['id'] }}">{{ $styleTab['label'] }}</button>
                @endforeach
            </div>

            <div class="st-footer-tab-divider"></div>

            {{-- Domestic Destinations --}}
            <div class="st-footer-tab-panel active" id="tab-domestic" role="tabpanel">
                <div class="st-footer-link-grid">
                    @forelse(($footerDomesticDestinations ?? collect()) as $destination)
                        <a href="{{ route('destinations.show', $destination) }}">{{ $destination->name }} Tour Destination</a>
                    @empty
                        <span class="footer-sub-text">No domestic destinations published yet.</span>
                    @endforelse
                </div>
            </div>

            {{-- International Destinations --}}
            <div class="st-footer-tab-panel" id="tab-international" role="tabpanel">
                <div class="st-footer-link-grid">
                    @forelse(($footerInternationalDestinations ?? collect()) as $destination)
                        <a href="{{ route('destinations.show', $destination) }}">{{ $destination->name }} Tour Destination</a>
                    @empty
                        <span class="footer-sub-text">No international destinations published yet.</span>
                    @endforelse
                </div>
            </div>

            @foreach(($footerTravelStyleTabs ?? []) as $styleTab)
                <div class="st-footer-tab-panel" id="tab-style-{{ $styleTab['id'] }}" role="tabpanel">
                    <div class="st-footer-link-grid">
                        @forelse(($styleTab['destinations'] ?? collect()) as $destination)
                            <a href="{{ route('destinations.show', $destination) }}">{{ $destination->name }} {{ $styleTab['label'] }} Destination</a>
                        @empty
                            <span class="footer-sub-text">No {{ strtolower($styleTab['label']) }} destinations published yet.</span>
                        @endforelse
                    </div>
                </div>
            @endforeach

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
                        <li><a href="/about-page">About Us</a></li>
                        <li><a href="{{ route('careers.index') }}">Careers</a></li>
                        <li><a href="{{ route('reviews.index') }}">SHABDD Reviews</a></li>
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
                        <li><a href="{{ route('terms.conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policies</a></li>
                        <li><a href="{{ route('copyright.policy') }}">Copyright Policies</a></li>
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
                        <li><a href="{{ route('support') }}">Support</a></li>
                        <li><a href="/blogs">Blog</a></li>
                     
                        <li><a href="/travel-agent-join-us">Partner With SHABDD</a></li>
                      
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
                                    <img src="/footericon/facebook.png" alt="Facebook" class="st-social-icon-img">
                                </span>
                                Facebook
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- Instagram --}}
                                <span class="st-social-icon">
                                  <img src="/footericon/instagram.png" alt="Instagram" class="st-social-icon-img">
                                </span>
                                Instagram
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- X / Twitter --}}
                                <span class="st-social-icon">
                                   <img src="/footericon/x.com.png" alt="X.com" class="st-social-icon-img">
                                </span>
                                X.com
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- LinkedIn --}}
                                <span class="st-social-icon">
                                   <img src="/footericon/linkedin.png" alt="LinkedIn" class="st-social-icon-img">
                                </span>
                                Linkedin
                            </a>
                        </li>

                        <li>
                            <a href="#" class="st-footer-social-link">
                                {{-- YouTube --}}
                                <span class="st-social-icon">
                                    <img src="/footericon/youtub.png" alt="YouTube" class="st-social-icon-img">
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
                    <img src="{{ asset('images/footer-logo.png') }}" alt="SHABDD" class="st-footer-logo">
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
