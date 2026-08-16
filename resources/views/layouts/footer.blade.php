<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="footer-logo">
                    <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="BeautyCare Logo" width="50" height="50" style="border-radius: 10px;">
                    BeautyCare
                </a>
                <p>Solusi manajemen bisnis kecantikan terpercaya untuk Salon, Spa, Nail Art, Barbershop, dan Skincare. Kelola bisnis Anda dengan lebih mudah dan efisien.</p>
                <div class="footer-social">
                    @php
                        $sosmedList = json_decode(optional($pengaturan)->sosmed ?? '[]', true) ?: [];
                        $sosmedIcons = [
                            'instagram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
                            'facebook' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
                            'twitter' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
                            'youtube' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>',
                            'tiktok' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>',
                            'whatsapp' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>',
                            'telegram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                            'line' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M18.93 8.74c0-3.44-3.11-6.24-6.93-6.24S5.07 5.3 5.07 8.74c0 3.1 2.52 5.7 5.93 6.15.23.05.55.16.63.37.07.19.05.48.02.68l-.1.62c-.03.2-.15.79.7.43.85-.36 4.57-2.69 6.24-4.6 1.14-1.3 1.64-2.61 1.64-3.75zM7.34 10.8a.47.47 0 0 1-.47.47H5.16a.47.47 0 0 1-.47-.47V7.7c0-.26.21-.47.47-.47s.47.21.47.47v2.16h1.24a.47.47 0 0 1 .47.47v.47zm1.22-.47c0 .26-.21.47-.47.47s-.47-.21-.47-.47V7.7c0-.26.21-.47.47-.47s.47.21.47.47v2.63zm1.22.47c0 .26-.21.47-.47.47s-.47-.21-.47-.47V7.7c0-.26.21-.47.47-.47s.47.21.47.47v3.1zm1.69-3.8h-1.7a.47.47 0 0 0-.47.47v3.33c0 .26.21.47.47.47s.47-.21.47-.47V8.29h1.23a.47.47 0 0 0 0-.94zm2.05 3.8c0 .26-.21.47-.47.47s-.47-.21-.47-.47V8.53c0-.26.21-.47.47-.47s.47.21.47.47v2.27zm.58-4.26h1.7a.47.47 0 0 1 0 .94h-1.23v.63h1.23a.47.47 0 0 1 0 .94h-1.7a.47.47 0 0 1-.47-.47V7.7c0-.26.21-.47.47-.47zm5.21 4.06c0 .26-.21.47-.47.47s-.47-.21-.47-.47V7.7c0-.26.21-.47.47-.47s.47.21.47.47v2.63z"/></svg>',
                        ];
                    @endphp
                    @forelse ($sosmedList as $sosmed)
                        @if (!empty($sosmed['url']))
                            <a href="{{ $sosmed['url'] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($sosmed['platform'] ?? 'Sosial Media') }}">
                                {!! $sosmedIcons[$sosmed['platform'] ?? ''] ?? $sosmedIcons['instagram'] !!}
                            </a>
                        @endif
                    @empty
                        <span class="text-sm text-gray-400">Belum ada sosial media</span>
                    @endforelse
                </div>
            </div>

            <div>
                <h4>Menu</h4>
                <ul class="footer-links">
                    <li><a href="#hero">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#membership">Membership</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="{{ route('help.index') }}">Pusat Bantuan</a></li>
                </ul>
            </div>

            <div>
                <h4>Kontak</h4>
                <ul class="footer-contact">
                    <li>
                        <span class="contact-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        {{ optional($pengaturan)->alamat ?? 'Jakarta Pusat, Indonesia' }}
                    </li>
                    <li>
                        <span class="contact-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        {{ optional($pengaturan)->telepon ?? '+62 812 3456 7890' }}
                    </li>
                    <li>
                        <span class="contact-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        {{ optional($pengaturan)->email ?? 'hello@beautycare.id' }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} BeautyCare. All rights reserved. Made with love for beauty business.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/animation.js') }}"></script>
@stack('scripts')
</body>
</html>
