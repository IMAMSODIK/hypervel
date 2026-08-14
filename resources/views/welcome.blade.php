<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Company') }}</title>
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
    <style>
        body { font-family: 'Inter', sans-serif; }
        .fade-out { opacity: 0; transition: opacity 0.5s; }

        /* About overlapping images animations */
        @keyframes floatY { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes floatY2 { 0%,100% { transform: translateY(0); } 50% { transform: translateY(8px); } }
        @keyframes pulseShadow { 0%,100% { box-shadow: 0 10px 25px rgba(38,60,146,0.18); } 50% { box-shadow: 0 18px 40px rgba(38,60,146,0.32); } }
        .about-img-main { animation: floatY 6s ease-in-out infinite; }
        .about-img-overlay { animation: floatY2 6s ease-in-out infinite; animation-delay: 0.8s; }
        .about-badge { animation: pulseShadow 3s ease-in-out infinite; }

        /* Entrance on scroll */
        .about-images-wrap .about-gold-block,
        .about-images-wrap .about-img-main,
        .about-images-wrap .about-img-overlay,
        .about-images-wrap .about-badge { opacity: 0; }
        .about-images-wrap.in-view .about-gold-block { animation: fadeInScale 0.7s ease forwards; }
        .about-images-wrap.in-view .about-img-main { animation: fadeInLeft 0.8s ease 0.15s forwards, floatY 6s ease-in-out 0.95s infinite; }
        .about-images-wrap.in-view .about-img-overlay { animation: fadeInRight 0.8s ease 0.35s forwards, floatY2 6s ease-in-out 1.75s infinite; }
        .about-images-wrap.in-view .about-badge { animation: fadeInUp 0.7s ease 0.55s forwards, pulseShadow 3s ease-in-out 1.25s infinite; }
        @keyframes fadeInScale { from { opacity:0; transform: scale(0.6); } to { opacity:1; transform: scale(1); } }
        @keyframes fadeInLeft { from { opacity:0; transform: translateX(-40px); } to { opacity:1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity:0; transform: translateX(40px); } to { opacity:1; transform: translateX(0); } }
        @keyframes fadeInUp { from { opacity:0; transform: translateY(24px); } to { opacity:1; transform: translateY(0); } }
        @media (prefers-reduced-motion: reduce) {
            .about-img-main, .about-img-overlay, .about-badge { animation: none !important; }
            .about-images-wrap .about-gold-block,
            .about-images-wrap .about-img-main,
            .about-images-wrap .about-img-overlay,
            .about-images-wrap .about-badge { opacity: 1 !important; }
        }

        /* Services slider */
        .services-track { will-change: transform; }
        .services-slide { width: 100%; }
        .services-track { gap: 1.25rem; }
        @media (min-width: 640px) { .services-slide { width: calc((100% - 1.25rem) / 2); } }
        @media (min-width: 768px) { .services-slide { width: calc((100% - 2.5rem) / 3); } }
        @media (min-width: 1024px) { .services-slide { width: calc((100% - 3.75rem) / 4); } }
        .slider-dot { width: 10px; height: 10px; border-radius: 9999px; background: rgba(38,60,146,0.22); transition: all .25s; cursor: pointer; }
        .slider-dot.active { width: 28px; background: #DFB624; }
        @media (prefers-reduced-motion: reduce) { .services-track { transition: none !important; } }
    </style>
</head>
<body class="bg-white text-slate-800">

@php
    $phone = \App\Models\Setting::get('contact_phone');
    $phone2 = \App\Models\Setting::get('contact_phone2');
    $email = \App\Models\Setting::get('contact_email');
    $address = \App\Models\Setting::get('contact_address');
    $hours = \App\Models\Setting::get('contact_hours');
    $facebook = \App\Models\Setting::get('contact_facebook');
    $linkedin = \App\Models\Setting::get('contact_linkedin');
    $instagram = \App\Models\Setting::get('contact_instagram');
    $youtube = \App\Models\Setting::get('contact_youtube');
    $heroTitle = \App\Models\Setting::get('hero_title', 'Delivering Excellence in Valve & Actuator Solutions');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Your trusted partner for industrial valve distribution and after-sales service.');
    $heroVideo = \App\Models\Setting::get('hero_video');
    $mapEmbed = \App\Models\Setting::get('contact_map_embed');
    $aboutSubtitle = \App\Models\Setting::get('about_subtitle');
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
            <a href="#" class="hover:text-primary transition-colors">Home</a>
            <a href="#about" class="hover:text-primary transition-colors">About</a>
            <a href="#products" class="hover:text-primary transition-colors">Products</a>
            <a href="{{ route('projects.index') }}" class="hover:text-primary transition-colors">Projects</a>
            <a href="#services" class="hover:text-primary transition-colors">Services</a>
            <a href="#contact" class="hover:text-primary transition-colors">Contact</a>
            <a href="#contact" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors font-semibold">Get a Quote</a>
        </div>
        <button class="md:hidden text-primary text-2xl" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
    </div>
    <div class="md:hidden hidden border-t border-slate-100" id="mobileMenu">
        <div class="flex flex-col gap-2 p-4 text-sm font-medium text-slate-600">
            <a href="#" class="py-1 hover:text-primary">Home</a>
            <a href="#about" class="py-1 hover:text-primary">About</a>
            <a href="#products" class="py-1 hover:text-primary">Products</a>
            <a href="{{ route('projects.index') }}" class="py-1 hover:text-primary">Projects</a>
            <a href="#services" class="py-1 hover:text-primary">Services</a>
            <a href="#contact" class="py-1 hover:text-primary">Contact</a>
            <a href="#contact" class="bg-primary text-white px-4 py-2 rounded-lg text-center font-semibold">Get a Quote</a>
        </div>
    </div>
</nav>

{{-- Hero Section --}}
<section class="relative w-full overflow-hidden" style="height:100vh; min-height:600px;">
    @if($heroVideo)
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline preload="metadata"
               poster="{{ asset('auth_assets/logo/logo.png') }}">
            <source src="{{ $heroVideo }}" type="video/mp4">
        </video>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-light to-primary-dark"></div>
    @endif
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 w-full">
            <div class="max-w-2xl text-white">
                <span class="inline-block bg-gold text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-4">Industrial Valve &amp; Actuator</span>
                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 drop-shadow-lg">{{ $heroTitle }}</h1>
                <p class="text-lg text-slate-100 mb-8 leading-relaxed drop-shadow">{{ $heroSubtitle }}</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#products" class="bg-gold text-primary font-semibold px-6 py-3 rounded-lg hover:opacity-90 transition-opacity inline-flex items-center gap-2">
                        Explore Products <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#contact" class="border border-white/40 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors inline-flex items-center gap-2 backdrop-blur-sm">
                        <i class="bi bi-telephone"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gold to-primary-light z-20"></div>
</section>

{{-- Stats Section --}}
@php $statistics = \App\Models\Statistic::active()->get(); @endphp
@if($statistics->isNotEmpty())
<section class="py-10 bg-slate-50" id="stats-section">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-6 text-center mx-auto" style="max-width:912px;">
            @foreach ($statistics as $stat)
                <div class="group relative bg-white rounded-xl px-4 py-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg w-full sm:w-auto sm:flex-1" style="min-width:180px;max-width:208px;border:1px solid rgba(0,0,0,0.06);">
                    <div class="absolute top-0 left-0 right-0 h-0.5 rounded-t-xl bg-gradient-to-r from-gold to-gold-light opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    @if($stat->icon)
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 mb-3 transition-transform duration-300 group-hover:scale-110">
                            <i class="bi {{ $stat->icon }} text-primary text-lg"></i>
                        </div>
                    @endif
                    <div class="text-2xl font-extrabold mb-1 text-primary">
                        <span class="stat-counter" data-target="{{ $stat->value }}">0</span>{{ $stat->suffix }}
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest text-slate-500">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
    (function () {
        const counters = document.querySelectorAll('.stat-counter');
        let started = false;

        function animateCounter(el, target, duration) {
            const start = 0;
            const startTime = performance.now();

            function update(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const value = Math.floor(eased * target);
                el.textContent = value.toLocaleString();
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.textContent = target.toLocaleString();
                }
            }

            requestAnimationFrame(update);
        }

        const io = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !started) {
                    started = true;
                    counters.forEach(function (el) {
                        const target = parseInt(el.dataset.target, 10) || 0;
                        animateCounter(el, target, 2000);
                    });
                    observer.disconnect();
                }
            });
        }, { threshold: 0.3 });

        const section = document.getElementById('stats-section');
        if (section) io.observe(section);
    })();
</script>

{{-- About Section --}}
@php
    $aboutTitle = \App\Models\Setting::get('about_title', 'Excellence in Engineering Solutions');
    $aboutSubtitle = \App\Models\Setting::get('about_subtitle', '');
    $aboutImage1 = \App\Models\Setting::get('about_image1');
    $aboutImage2 = \App\Models\Setting::get('about_image2');
    $aboutBullets = \App\Models\Setting::get('about_bullets', '');
    $aboutBullets = $aboutBullets ? explode('|', $aboutBullets) : [];
@endphp
<section id="about" class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            {{-- Left: text --}}
            <div>
                <span class="text-gold font-semibold uppercase tracking-wider text-sm">About Us</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2 mb-4">{{ $aboutTitle }}</h2>
                <div class="w-16 h-1 bg-gold mb-6 rounded-full"></div>
                @if($aboutSubtitle)
                    <p class="text-slate-600 leading-relaxed mb-6">{{ $aboutSubtitle }}</p>
                @endif
                @if(!empty($aboutBullets))
                    <div class="flex flex-col gap-3 mb-8">
                        @foreach($aboutBullets as $bullet)
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary/10 shrink-0">
                                    <i class="bi bi-check-lg text-primary text-sm"></i>
                                </div>
                                <span class="font-medium">{{ $bullet }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                <a href="{{ route('about.page') }}" class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                    More About Us <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Right: overlapping images --}}
            <div class="relative about-images-wrap" style="height:460px;">
                {{-- Dotted pattern background (subtle) --}}
                <div class="absolute pointer-events-none" style="bottom:6px;right:6px;width:60%;height:68%;background-image:radial-gradient(rgba(38,60,146,0.14) 1.5px,transparent 1.5px);background-size:18px 18px;z-index:0;"></div>
                {{-- Gold accent block peeking top-left --}}
                <div class="absolute rounded-2xl bg-gold about-gold-block" style="width:70%;height:78%;top:-14px;left:-14px;z-index:1;"></div>
                {{-- Main image --}}
                <div class="absolute rounded-2xl overflow-hidden shadow-xl ring-1 ring-black/5 z-10 about-img-main" style="width:70%;height:78%;top:0;left:0;">
                    @if($aboutImage1)
                        <img src="{{ $aboutImage1 }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" alt="About 1">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/70" style="background:linear-gradient(135deg,#263C92,#1d2d6e);"><i class="bi bi-image text-5xl"></i></div>
                    @endif
                </div>
                {{-- Overlay image (front) --}}
                @if($aboutImage2)
                    <div class="absolute rounded-2xl overflow-hidden shadow-2xl ring-4 ring-white z-20 about-img-overlay" style="width:48%;height:62%;bottom:0;right:0;">
                        <img src="{{ $aboutImage2 }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="About 2">
                    </div>
                @endif
                {{-- Experience badge --}}
                @php $expStat = $statistics->firstWhere('label','Years Experience'); @endphp
                @if($expStat)
                    <div class="absolute bg-primary text-white rounded-2xl shadow-xl px-5 py-3 text-center z-30 about-badge" style="bottom:-16px;left:6%;">
                        <div class="text-3xl font-extrabold text-gold leading-none">{{ $expStat->value }}{{ $expStat->suffix }}</div>
                        <div class="text-[11px] uppercase tracking-wide text-white/80 mt-1">Years Experience</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Products Section --}}
@php $products = \App\Models\Product::active()->get(); @endphp
<section id="products" class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Our Products</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Premium Industrial Solutions</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
            <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Discover our comprehensive range of industrial equipment, engineered for reliability and performance.</p>
        </div>
        @if($products->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="h-52 relative overflow-hidden">
                        @if($product->featured_image)
                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                @if($product->icon)
                                    <i class="bi {{ $product->icon }} text-white/90 text-7xl group-hover:scale-110 transition-transform duration-500"></i>
                                @else
                                    <i class="bi bi-grid text-white/50 text-7xl"></i>
                                @endif
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 inline-flex items-center justify-center w-9 h-9 rounded-full bg-gold text-primary font-bold text-sm shadow-md">{{ $loop->index + 1 }}</span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="font-bold text-lg text-slate-800 mb-2 group-hover:text-primary transition-colors">{{ $product->title }}</h3>
                        <div class="w-10 h-0.5 bg-gold rounded-full mb-3 transition-all duration-300 group-hover:w-16"></div>
                        <p class="text-sm text-slate-500 leading-relaxed flex-grow">{{ $product->short_description }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary group-hover:gap-2.5 transition-all">
                            View Details <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
        @else
            <div class="text-center text-slate-400 py-10">No products published yet.</div>
        @endif
    </div>
</section>

{{-- Services / Capabilities Section --}}
@php $services = \App\Models\Service::active()->get(); @endphp
<section id="services" class="py-20 relative overflow-hidden" style="background:linear-gradient(180deg,#f8fafc 0%,#eef2ff 60%,#f8fafc 100%);">
    {{-- Decorative blobs --}}
    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-gold/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Our Capabilities</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Services We Deliver</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
            <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Comprehensive engineering support across the industrial value chain — from consultancy to installation, spares, and training.</p>
        </div>

        @if($services->isNotEmpty())
        {{-- Slider --}}
        <div class="services-slider relative">
            {{-- Track --}}
            <div class="services-track-wrap overflow-hidden px-1">
                <div class="services-track flex transition-transform duration-500 ease-out gap-5" id="servicesTrack">
                    @foreach($services as $service)
                        <div class="services-slide shrink-0">
                            <article class="group relative bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-slate-100 hover:ring-primary/20 transition-all duration-300 h-full flex flex-col">
                                {{-- Image / icon header --}}
                                <div class="relative h-44 overflow-hidden">
                                    @if($service->image)
                                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/70 via-primary-dark/20 to-transparent"></div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                            @if($service->icon)
                                                <i class="bi {{ $service->icon }} text-white/90 text-6xl group-hover:scale-110 transition-transform duration-500"></i>
                                            @else
                                                <i class="bi bi-grid text-white/50 text-6xl"></i>
                                            @endif
                                        </div>
                                    @endif
                                    {{-- Number badge --}}
                                    <span class="absolute top-4 left-4 inline-flex items-center justify-center w-8 h-8 rounded-full bg-gold text-primary font-bold text-sm shadow-md">{{ $loop->index + 1 }}</span>
                                    @if($service->icon && $service->image)
                                        <span class="absolute bottom-4 left-4 inline-flex items-center justify-center w-11 h-11 rounded-xl bg-white/95 shadow-md">
                                            <i class="bi {{ $service->icon }} text-primary text-xl"></i>
                                        </span>
                                    @endif
                                </div>
                                {{-- Body --}}
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="font-bold text-lg text-slate-800 mb-2 group-hover:text-primary transition-colors">{{ $service->title }}</h3>
                                    <div class="w-10 h-0.5 bg-gold rounded-full mb-3 transition-all duration-300 group-hover:w-16"></div>
                                    <p class="text-sm text-slate-500 leading-relaxed flex-grow">{{ $service->description }}</p>
                                    <a href="#contact" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:gap-2.5 transition-all">
                                        Learn more <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Controls --}}
            <button class="slider-btn slider-prev absolute top-1/2 -translate-y-1/2 -left-2 md:-left-5 z-20 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white shadow-lg ring-1 ring-slate-200 text-primary hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 disabled:opacity-40 disabled:hover:scale-100 disabled:hover:bg-white disabled:hover:text-primary" aria-label="Previous">
                <i class="bi bi-chevron-left text-xl"></i>
            </button>
            <button class="slider-btn slider-next absolute top-1/2 -translate-y-1/2 -right-2 md:-right-5 z-20 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white shadow-lg ring-1 ring-slate-200 text-primary hover:bg-primary hover:text-white transition-all duration-300 hover:scale-110 disabled:opacity-40 disabled:hover:scale-100 disabled:hover:bg-white disabled:hover:text-primary" aria-label="Next">
                <i class="bi bi-chevron-right text-xl"></i>
            </button>

            {{-- Dots --}}
            <div class="flex justify-center gap-2 mt-8" id="servicesDots"></div>
        </div>
        @else
            <div class="text-center text-slate-400 py-10">No capabilities published yet.</div>
        @endif
    </div>
</section>

{{-- Featured Projects Section --}}
@php $featuredProjects = \App\Models\Project::active()->featured()->limit(3)->get(); @endphp
<section id="projects" class="py-20 relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-10 right-0 w-72 h-72 rounded-full bg-gold/5 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-12">
            <div>
                <span class="text-gold font-semibold uppercase tracking-wider text-sm">Featured Projects</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Our Recent Work</h2>
                <div class="w-20 h-1 bg-gold rounded-full mt-4"></div>
            </div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:gap-3 transition-all">
                View More Projects <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($featuredProjects->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="h-56 relative overflow-hidden">
                        @if($project->featured_image)
                            <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/60 via-transparent to-transparent"></div>
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                @if($project->icon)
                                    <i class="bi {{ $project->icon }} text-white/90 text-7xl group-hover:scale-110 transition-transform duration-500"></i>
                                @else
                                    <i class="bi bi-kanban text-white/50 text-7xl"></i>
                                @endif
                            </div>
                        @endif
                        @if($project->category)
                            <span class="absolute top-4 left-4 bg-gold text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-md">{{ $project->category }}</span>
                        @endif
                        @if($project->year)
                            <span class="absolute bottom-4 right-4 bg-white/95 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-full shadow-md">{{ $project->year }}</span>
                        @endif
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="font-bold text-lg text-slate-800 mb-2 group-hover:text-primary transition-colors">{{ $project->title }}</h3>
                        <div class="w-10 h-0.5 bg-gold rounded-full mb-3 transition-all duration-300 group-hover:w-16"></div>
                        <p class="text-sm text-slate-500 leading-relaxed flex-grow">{{ $project->short_description }}</p>
                        @if($project->client || $project->location)
                            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400">
                                @if($project->client)
                                    <span class="inline-flex items-center gap-1"><i class="bi bi-building"></i>{{ $project->client }}</span>
                                @endif
                                @if($project->location)
                                    <span class="inline-flex items-center gap-1"><i class="bi bi-geo-alt"></i>{{ $project->location }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-7 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                View More Projects <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        @else
            <div class="text-center text-slate-400 py-10">No featured projects yet.</div>
        @endif
    </div>
</section>

{{-- Our Clients Section --}}
@php $clients = \App\Models\Client::active()->get(); @endphp
@if($clients->isNotEmpty())
<section id="clients" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Trusted By</span>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mt-2">Our Valued Clients</h2>
            <div class="w-16 h-1 bg-gold mx-auto mt-3 rounded-full"></div>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($clients as $client)
                <div class="group relative bg-white rounded-xl border border-slate-100 shadow-sm flex items-center justify-center overflow-hidden transition-all duration-300 hover:shadow-md hover:border-primary/20" style="aspect-ratio:3/2;width:calc((100% - 6rem)/5);max-width:200px;min-width:130px;">
                    @if($client->logo)
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="max-w-full max-h-full object-contain p-4 transition-all duration-300 {{ $client->website ? 'group-hover:opacity-0' : '' }}">
                    @else
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary text-white">
                            <i class="bi bi-building text-xl"></i>
                        </div>
                    @endif
                    {{-- Hover: company name overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ $client->website ? 'bg-primary/90' : 'bg-primary/85' }}">
                        <div class="text-center px-3">
                            <div class="text-white font-bold text-sm leading-tight">{{ $client->name }}</div>
                            @if($client->website)
                                <div class="text-gold text-xs mt-1">Visit site <i class="bi bi-box-arrow-up-right"></i></div>
                            @endif
                        </div>
                    </div>
                    @if($client->website)
                        <a href="{{ $client->website }}" target="_blank" class="absolute inset-0 z-10" aria-label="{{ $client->name }}"></a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Contact Section --}}
<section id="contact" class="bg-primary py-20 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Contact Us</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">Get In Touch</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
            <p class="text-slate-200 mt-4 max-w-2xl mx-auto">Have a question or want to collaborate? Send us a message and our team will get back to you.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-10 items-start">

            {{-- Left: contact info --}}
            <div>
                <div class="grid sm:grid-cols-2 gap-6 mb-8">
                    @if($phone)
                    <div class="p-6 bg-white/10 rounded-xl">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-telephone-fill text-2xl"></i></div>
                        <h3 class="font-bold mb-2">Phone</h3>
                        @if($phone2)<p class="text-sm text-slate-200">{{ $phone }}</p><p class="text-sm text-slate-200">{{ $phone2 }}</p>@else<p class="text-sm text-slate-200">{{ $phone }}</p>@endif
                    </div>
                    @endif
                    @if($email)
                    <div class="p-6 bg-white/10 rounded-xl">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-envelope-fill text-2xl"></i></div>
                        <h3 class="font-bold mb-2">Email</h3>
                        <p class="text-sm text-slate-200 break-all">{{ $email }}</p>
                    </div>
                    @endif
                    @if($address)
                    <div class="p-6 bg-white/10 rounded-xl">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-geo-alt-fill text-2xl"></i></div>
                        <h3 class="font-bold mb-2">Address</h3>
                        <p class="text-sm text-slate-200">{!! nl2br(e($address)) !!}</p>
                    </div>
                    @endif
                    @if($hours)
                    <div class="p-6 bg-white/10 rounded-xl">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-clock-fill text-2xl"></i></div>
                        <h3 class="font-bold mb-2">Operating Hours</h3>
                        <p class="text-sm text-slate-200">{!! nl2br(e($hours)) !!}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: contact form --}}
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @if(session('inquiry_success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm flex items-start gap-2">
                        <i class="bi bi-check-circle-fill mt-0.5"></i>
                        <span>{{ session('inquiry_success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.inquiry') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-slate-800"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-slate-800"
                            placeholder="john@company.com">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Company</label>
                            <input type="text" name="company" value="{{ old('company') }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-slate-800"
                                placeholder="Company name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-slate-800"
                                placeholder="+60 123 4567">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all text-slate-800 resize-none"
                            placeholder="Tell us about your inquiry...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors inline-flex items-center justify-center gap-2">
                        Send Message <i class="bi bi-send"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
@include('partials.footer')

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });

    (function () {
        var wrap = document.querySelector('.about-images-wrap');
        if (!wrap || !('IntersectionObserver' in window)) {
            if (wrap) wrap.classList.add('in-view');
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in-view'); io.unobserve(e.target); }
            });
        }, { threshold: 0.25 });
        io.observe(wrap);
    })();

    /* Services slider — infinite loop autoplay */
    (function () {
        var track = document.getElementById('servicesTrack');
        var dotsWrap = document.getElementById('servicesDots');
        if (!track) return;
        var slides = Array.prototype.slice.call(track.querySelectorAll('.services-slide'));
        var total = slides.length;
        if (total === 0) return;
        var prevBtn = document.querySelector('.slider-prev');
        var nextBtn = document.querySelector('.slider-next');
        var slider = document.querySelector('.services-slider');
        var gap = 20;
        var autoplayMs = 4500;
        var timer = null;

        function perView() {
            var w = window.innerWidth;
            if (w >= 1024) return 3;
            if (w >= 768) return 2;
            if (w >= 640) return 2;
            return 1;
        }

        var view = perView();
        var index = 0;               // logical index of real slide (0-based)
        var transitioning = false;

        function step() {
            var sw = track.querySelector('.services-slide').getBoundingClientRect().width;
            return sw + gap;
        }

        // Clone: last `view` slides prepended, first `view` slides appended
        function buildClones() {
            // clear old clones
            Array.prototype.forEach.call(track.querySelectorAll('.clone-slide'), function (el) { el.remove(); });
            var n = Math.min(view, total);
            for (var i = 0; i < n; i++) {
                var lastClone = slides[total - 1 - i].cloneNode(true);
                lastClone.classList.add('clone-slide');
                lastClone.setAttribute('aria-hidden', 'true');
                track.insertBefore(lastClone, track.firstChild);
                var firstClone = slides[i].cloneNode(true);
                firstClone.classList.add('clone-slide');
                firstClone.setAttribute('aria-hidden', 'true');
                track.appendChild(firstClone);
            }
        }

        function render(noAnim) {
            track.style.transition = noAnim ? 'none' : '';
            track.style.transform = 'translateX(' + (-step() * (index + view)) + 'px)';
        }

        function pages() { return total; }

        function updateDots() {
            dotsWrap.innerHTML = '';
            var current = (index + total) % total;
            for (var i = 0; i < total; i++) {
                (function (p) {
                    var dot = document.createElement('button');
                    dot.className = 'slider-dot' + (p === current ? ' active' : '');
                    dot.setAttribute('aria-label', 'Go to slide ' + (p + 1));
                    dot.addEventListener('click', function () {
                        index = p; render(); restart();
                    });
                    dotsWrap.appendChild(dot);
                })(i);
            }
        }

        function onTransitionEnd() {
            if (transitioning) {
                transitioning = false;
                // if past real end (in appended clones)
                if (index >= total) { index = index - total; render(true); }
                // if before real start (in prepended clones)
                else if (index < 0) { index = index + total; render(true); }
                updateDots();
            }
        }

        function next() {
            if (transitioning) return;
            transitioning = true;
            index++;
            render();
        }
        function prev() {
            if (transitioning) return;
            transitioning = true;
            index--;
            render();
        }

        function start() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            if (timer) clearInterval(timer);
            timer = setInterval(next, autoplayMs);
        }
        function restart() { if (timer) clearInterval(timer); start(); }

        prevBtn?.addEventListener('click', function () { prev(); restart(); });
        nextBtn?.addEventListener('click', function () { next(); restart(); });

        track.addEventListener('transitionend', onTransitionEnd);

        // Pause on hover
        slider?.addEventListener('mouseenter', function () { if (timer) { clearInterval(timer); timer = null; } });
        slider?.addEventListener('mouseleave', start);

        // Touch / drag
        var startX = null, dragging = false, startTransform = 0;
        function onDown(e) {
            startX = (e.touches ? e.touches[0].clientX : e.clientX);
            dragging = true; transitioning = false;
            if (timer) { clearInterval(timer); timer = null; }
            track.style.transition = 'none';
            startTransform = -step() * (index + view);
        }
        function onMove(e) {
            if (!dragging) return;
            var x = (e.touches ? e.touches[0].clientX : e.clientX);
            track.style.transform = 'translateX(' + (startTransform + (x - startX)) + 'px)';
        }
        function onUp(e) {
            if (!dragging) return;
            dragging = false; track.style.transition = '';
            var x = (e.changedTouches ? e.changedTouches[0].clientX : e.clientX);
            var dx = x - startX; startX = null;
            if (Math.abs(dx) > 40) { dx < 0 ? next() : prev(); }
            else { render(); }
            restart();
        }
        track.addEventListener('mousedown', onDown);
        track.addEventListener('mousemove', onMove);
        window.addEventListener('mouseup', onUp);
        track.addEventListener('touchstart', onDown, { passive: true });
        track.addEventListener('touchmove', onMove, { passive: true });
        track.addEventListener('touchend', onUp);
        track.addEventListener('mouseleave', function () { if (dragging) { dragging = false; track.style.transition = ''; render(); restart(); } });

        function onResize() {
            var nv = perView();
            if (nv !== view) { view = nv; buildClones(); }
            if (index >= total) index = index % total;
            if (index < 0) index = (index + total) % total;
            render(true);
            updateDots();
        }
        var rt;
        window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(onResize, 150); });

        // Immortalize: keep autoplay running
        setInterval(function () { if (!timer && !dragging) start(); }, 2000);

        // init
        buildClones();
        render(true);
        updateDots();
        start();
    })();
</script>

</body>
</html>