<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#263C92', light: '#3a54b0', dark: '#1d2d6e' },
                        gold: { DEFAULT: '#DFB624', light: '#e8c64a', dark: '#c49e1a' },
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }
    @keyframes floatY { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes floatY2 { 0%,100% { transform: translateY(0); } 50% { transform: translateY(8px); } }
    @keyframes fadeInScale { from { opacity:0; transform: scale(0.6); } to { opacity:1; transform: scale(1); } }
    @keyframes fadeInLeft { from { opacity:0; transform: translateX(-40px); } to { opacity:1; transform: translateX(0); } }
    @keyframes fadeInRight { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform: translateX(0); } }
    .about-img-main { animation: floatY 6s ease-in-out infinite; }
    .about-img-overlay { animation: floatY2 6s ease-in-out infinite; animation-delay: 0.8s; }
    .about-images-wrap .about-gold-block,
    .about-images-wrap .about-img-main,
    .about-images-wrap .about-img-overlay { opacity: 0; }
    .about-images-wrap.in-view .about-gold-block { animation: fadeInScale 0.7s ease forwards; }
    .about-images-wrap.in-view .about-img-main { animation: fadeInLeft 0.8s ease 0.15s forwards, floatY 6s ease-in-out 0.95s infinite; }
    .about-images-wrap.in-view .about-img-overlay { animation: fadeInRight 0.8s ease 0.35s forwards, floatY2 6s ease-in-out 1.15s infinite; }
    @media (prefers-reduced-motion: reduce) {
        .about-img-main, .about-img-overlay { animation: none !important; }
        .about-images-wrap .about-gold-block,
        .about-images-wrap .about-img-main,
        .about-images-wrap .about-img-overlay { opacity: 1 !important; }
    }
</style>
</head>
<body class="bg-white text-slate-800">

@php
    $settings = \App\Models\Setting::getMany(['about_title','about_subtitle','about_description','about_bullets','about_image1','about_image2']);
    $bullets = $settings['about_bullets'] ?? '';
    $bullets = $bullets ? explode('|', $bullets) : [];
    $phone = \App\Models\Setting::get('contact_phone');
    $phone2 = \App\Models\Setting::get('contact_phone2');
    $email = \App\Models\Setting::get('contact_email');
    $address = \App\Models\Setting::get('contact_address');
    $hours = \App\Models\Setting::get('contact_hours');
    $facebook = \App\Models\Setting::get('contact_facebook');
    $linkedin = \App\Models\Setting::get('contact_linkedin');
    $instagram = \App\Models\Setting::get('contact_instagram');
    $youtube = \App\Models\Setting::get('contact_youtube');
    $heroVideo = \App\Models\Setting::get('hero_video');
@endphp

{{-- Top Contact Bar --}}
<div class="bg-primary text-white text-sm py-2 px-4">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
            @if($phone)
                <a href="tel:{{ $phone }}" class="inline-flex items-center gap-1.5 hover:text-gold transition-colors">
                    <i class="bi bi-telephone-fill text-gold text-xs"></i>{{ $phone }}
                </a>
            @endif
            @if($email)
                <a href="mailto:{{ $email }}" class="inline-flex items-center gap-1.5 hover:text-gold transition-colors">
                    <i class="bi bi-envelope-fill text-gold text-xs"></i>{{ $email }}
                </a>
            @endif
            @if($hours)
                <span class="inline-flex items-center gap-1.5">
                    <i class="bi bi-clock-fill text-gold text-xs"></i>{{ $hours }}
                </span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            @if($facebook)
                <a href="{{ $facebook }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-facebook"></i></a>
            @endif
            @if($linkedin)
                <a href="{{ $linkedin }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-linkedin"></i></a>
            @endif
            @if($instagram)
                <a href="{{ $instagram }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-instagram"></i></a>
            @endif
            @if($youtube)
                <a href="{{ $youtube }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-youtube"></i></a>
            @endif
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1 bg-gold text-primary font-semibold px-3 py-1 rounded hover:opacity-90 transition-opacity">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            @endif
        </div>
    </div>
</div>

{{-- Navbar --}}
<nav class="bg-white shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
            <div class="flex flex-col leading-tight">
                <span class="font-bold text-base text-primary">{{ config('app.name') }}</span>
                <span class="text-xs text-slate-400">{{ config('app.description') }}</span>
            </div>
        </a>
        <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
            <a href="{{ url('/about') }}" class="text-primary font-semibold">About</a>
            <a href="{{ url('/') }}#products" class="hover:text-primary transition-colors">Products</a>
            <a href="{{ url('/') }}#services" class="hover:text-primary transition-colors">Services</a>
            <a href="{{ url('/') }}#contact" class="hover:text-primary transition-colors">Contact</a>
            <a href="{{ url('/') }}#contact" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors font-semibold">Get a Quote</a>
        </div>
        <button class="md:hidden text-primary text-2xl" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
    </div>
    <div class="md:hidden hidden border-t border-slate-100" id="mobileMenu">
        <div class="flex flex-col gap-2 p-4 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="py-1 hover:text-primary">Home</a>
            <a href="{{ url('/about') }}" class="py-1 text-primary font-semibold">About</a>
            <a href="{{ url('/') }}#products" class="py-1 hover:text-primary">Products</a>
            <a href="{{ url('/') }}#services" class="py-1 hover:text-primary">Services</a>
            <a href="{{ url('/') }}#contact" class="py-1 hover:text-primary">Contact</a>
            <a href="{{ url('/') }}#contact" class="bg-primary text-white px-4 py-2 rounded-lg text-center font-semibold">Get a Quote</a>
        </div>
    </div>
</nav>

{{-- Hero Section --}}
<section class="relative w-full overflow-hidden" style="height:70vh; min-height:480px;">
    @if($heroVideo)
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="metadata"
               poster="{{ asset('auth_assets/logo/logo.png') }}">
            <source src="{{ $heroVideo }}" type="video/mp4">
        </video>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-light to-primary-dark"></div>
    @endif
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="max-w-3xl mx-auto px-4 text-center text-white">
            <span class="inline-block bg-gold text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-4">About Us</span>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 drop-shadow-lg">{{ $settings['about_title'] ?: config('app.name') }}</h1>
            @if($settings['about_subtitle'] ?? '')
                <p class="text-lg text-slate-100 mb-8 leading-relaxed drop-shadow max-w-2xl mx-auto">{{ $settings['about_subtitle'] }}</p>
            @endif
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#about-content" class="bg-gold text-primary font-semibold px-6 py-3 rounded-lg hover:opacity-90 transition-opacity inline-flex items-center gap-2">
                    Learn More <i class="bi bi-arrow-down"></i>
                </a>
                <a href="{{ url('/') }}#contact" class="border border-white/40 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors inline-flex items-center gap-2 backdrop-blur-sm">
                    <i class="bi bi-telephone"></i> Contact Us
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gold to-primary-light z-20"></div>
</section>

{{-- About Content --}}
<section id="about-content" class="py-16">
    <div class="max-w-5xl mx-auto px-4">
        <p class="text-slate-600 leading-relaxed text-lg mb-6">{{ $settings['about_subtitle'] ?? '' }}</p>

        @if(!empty($bullets))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
                @foreach($bullets as $bullet)
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 shrink-0">
                            <i class="bi bi-check-lg text-primary"></i>
                        </div>
                        <span class="font-medium text-slate-700 pt-1">{{ $bullet }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!empty($settings['about_description']))
            <div class="text-slate-700 leading-relaxed space-y-4">
                {!! nl2br(e($settings['about_description'])) !!}
            </div>
        @endif

        @if(($settings['about_image1'] ?? '') || ($settings['about_image2'] ?? ''))
            <div class="relative mt-12 max-w-3xl mx-auto about-images-wrap" style="height:400px;">
                {{-- Dotted pattern background (subtle) --}}
                <div class="absolute pointer-events-none" style="bottom:6px;right:6px;width:60%;height:68%;background-image:radial-gradient(rgba(38,60,146,0.14) 1.5px,transparent 1.5px);background-size:18px 18px;z-index:0;"></div>
                {{-- Gold accent block peeking top-left --}}
                @if($settings['about_image1'] ?? '')
                    <div class="absolute rounded-2xl bg-gold about-gold-block" style="width:70%;height:78%;top:-14px;left:-14px;z-index:1;"></div>
                @endif
                @if($settings['about_image1'] ?? '')
                    <div class="absolute rounded-2xl overflow-hidden shadow-xl ring-1 ring-black/5 z-10 about-img-main" style="width:70%;height:78%;top:0;left:0;">
                        <img src="{{ $settings['about_image1'] }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" alt="About 1">
                    </div>
                @endif
                @if($settings['about_image2'] ?? '')
                    <div class="absolute rounded-2xl overflow-hidden shadow-2xl ring-4 ring-white z-20 about-img-overlay" style="width:48%;height:62%;bottom:0;right:0;">
                        <img src="{{ $settings['about_image2'] }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="About 2">
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-14 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold text-primary mb-3">Want to know more?</h3>
        <p class="text-slate-600 mb-6">Feel free to reach out — our team is ready to help.</p>
        <a href="{{ url('/') }}#contact" class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
            Contact Us <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-slate-900 text-slate-400 py-12">
    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
            </div>
            <p class="text-sm">{{ config('app.description') }}</p>
            <div class="flex gap-3 mt-4">
                @if($facebook)<a href="{{ $facebook }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-facebook"></i></a>@endif
                @if($linkedin)<a href="{{ $linkedin }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-linkedin"></i></a>@endif
                @if($instagram)<a href="{{ $instagram }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-instagram"></i></a>@endif
                @if($youtube)<a href="{{ $youtube }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-youtube"></i></a>@endif
            </div>
        </div>
        <div>
            <h4 class="font-bold text-white mb-4">Quick Links</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ url('/') }}" class="hover:text-gold transition-colors">Home</a></li>
                <li><a href="{{ url('/about') }}" class="hover:text-gold transition-colors">About Us</a></li>
                <li><a href="{{ url('/') }}#contact" class="hover:text-gold transition-colors">Contact</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-white mb-4">Contact</h4>
            <ul class="space-y-2 text-sm">
                @if($phone)<li><i class="bi bi-telephone me-2"></i>{{ $phone }}</li>@endif
                @if($email)<li><i class="bi bi-envelope me-2"></i>{{ $email }}</li>@endif
                @if($address)<li><i class="bi bi-geo-alt me-2"></i>{!! nl2br(e($address)) !!}</li>@endif
            </ul>
        </div>
    </div>
    <hr class="border-slate-700 my-8 max-w-7xl mx-auto">
    <div class="text-center text-sm">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</footer>

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
    (function () {
        var wrap = document.querySelector('.about-images-wrap');
        if (!wrap || !('IntersectionObserver' in window)) { if (wrap) wrap.classList.add('in-view'); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in-view'); io.unobserve(e.target); } });
        }, { threshold: 0.25 });
        io.observe(wrap);
    })();
</script>

</body>
</html>