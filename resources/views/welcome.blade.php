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
                <div class="group relative bg-white rounded-xl px-4 py-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg" style="width:208px;border:1px solid rgba(0,0,0,0.06);">
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
<section id="about" class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">About Us</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Excellence in Engineering Solutions</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div class="space-y-4 text-slate-600 leading-relaxed">
                <p>{{ config('app.name') }} is a trusted distributor and service provider specializing in industrial valves, actuators, and control systems. We serve the power generation, oil &amp; gas, petrochemical, and water treatment industries.</p>
                <p>With decades of experience, we deliver top-quality products from world-renowned brands, backed by comprehensive after-sales support, maintenance, and technical training services.</p>
                <div class="flex gap-6 pt-4">
                    <div class="flex items-center gap-2 text-primary font-semibold"><i class="bi bi-check-circle-fill text-gold"></i> Certified Quality</div>
                    <div class="flex items-center gap-2 text-primary font-semibold"><i class="bi bi-check-circle-fill text-gold"></i> Expert Support</div>
                    <div class="flex items-center gap-2 text-primary font-semibold"><i class="bi bi-check-circle-fill text-gold"></i> On-Time Delivery</div>
                </div>
            </div>
            <div class="bg-primary rounded-2xl p-8 text-white">
                <div class="space-y-4">
                    <h3 class="text-xl font-bold mb-4">Our Core Values</h3>
                    <div class="flex items-start gap-3"><i class="bi bi-award-fill text-gold text-xl mt-0.5"></i><div><div class="font-semibold">Integrity</div><div class="text-sm text-slate-300">We conduct business with honesty and transparency.</div></div></div>
                    <div class="flex items-start gap-3"><i class="bi bi-gear-fill text-gold text-xl mt-0.5"></i><div><div class="font-semibold">Innovation</div><div class="text-sm text-slate-300">Continuously improving our products and services.</div></div></div>
                    <div class="flex items-start gap-3"><i class="bi bi-people-fill text-gold text-xl mt-0.5"></i><div><div class="font-semibold">Customer Focus</div><div class="text-sm text-slate-300">Your success is our priority.</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Products Section --}}
<section id="products" class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Our Products</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Premium Industrial Solutions</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="bg-primary h-48 flex items-center justify-center"><i class="bi bi-gear text-white text-6xl"></i></div>
                <div class="p-6"><h3 class="font-bold text-lg mb-2 text-primary">Actuators</h3><p class="text-sm text-slate-500">Electric, pneumatic, and hydraulic actuators for reliable valve automation.</p></div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="bg-gold h-48 flex items-center justify-center"><i class="bi bi-funnel text-primary text-6xl"></i></div>
                <div class="p-6"><h3 class="font-bold text-lg mb-2 text-primary">Valves</h3><p class="text-sm text-slate-500">Ball, gate, globe, check, and control valves for all industrial applications.</p></div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="bg-primary h-48 flex items-center justify-center"><i class="bi bi-speedometer2 text-white text-6xl"></i></div>
                <div class="p-6"><h3 class="font-bold text-lg mb-2 text-primary">Control Systems</h3><p class="text-sm text-slate-500">Advanced control valves and desuperheaters for precise process control.</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Services Section --}}
<section id="services" class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Our Services</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Comprehensive Engineering Support</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-6 rounded-xl border border-slate-100 hover:border-primary hover:shadow-md transition-all">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary mb-4"><i class="bi bi-tools text-2xl"></i></div>
                <h3 class="font-bold mb-2">After-Sales Service</h3><p class="text-sm text-slate-500">Maintenance, repair, and overhaul support.</p>
            </div>
            <div class="text-center p-6 rounded-xl border border-slate-100 hover:border-primary hover:shadow-md transition-all">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary mb-4"><i class="bi bi-building text-2xl"></i></div>
                <h3 class="font-bold mb-2">Plant Betterment</h3><p class="text-sm text-slate-500">Upgrade and optimization solutions.</p>
            </div>
            <div class="text-center p-6 rounded-xl border border-slate-100 hover:border-primary hover:shadow-md transition-all">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary mb-4"><i class="bi bi-box-seam text-2xl"></i></div>
                <h3 class="font-bold mb-2">Inventory Supply</h3><p class="text-sm text-slate-500">Spare parts and stock management.</p>
            </div>
            <div class="text-center p-6 rounded-xl border border-slate-100 hover:border-primary hover:shadow-md transition-all">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary/10 text-primary mb-4"><i class="bi bi-easel text-2xl"></i></div>
                <h3 class="font-bold mb-2">Training</h3><p class="text-sm text-slate-500">Technical training and knowledge transfer.</p>
            </div>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section id="contact" class="bg-primary py-20 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-gold font-semibold uppercase tracking-wider text-sm">Contact Us</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">Get In Touch</h2>
            <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-4 gap-6">
            @if($phone)
            <div class="text-center p-6 bg-white/10 rounded-xl">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-telephone-fill text-2xl"></i></div>
                <h3 class="font-bold mb-2">Phone</h3>
                @if($phone2)<p class="text-sm text-slate-200">{{ $phone }}</p><p class="text-sm text-slate-200">{{ $phone2 }}</p>@else<p class="text-sm text-slate-200">{{ $phone }}</p>@endif
            </div>
            @endif
            @if($email)
            <div class="text-center p-6 bg-white/10 rounded-xl">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-envelope-fill text-2xl"></i></div>
                <h3 class="font-bold mb-2">Email</h3>
                <p class="text-sm text-slate-200 break-all">{{ $email }}</p>
            </div>
            @endif
            @if($address)
            <div class="text-center p-6 bg-white/10 rounded-xl">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-geo-alt-fill text-2xl"></i></div>
                <h3 class="font-bold mb-2">Address</h3>
                <p class="text-sm text-slate-200">{!! nl2br(e($address)) !!}</p>
            </div>
            @endif
            @if($hours)
            <div class="text-center p-6 bg-white/10 rounded-xl">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-gold text-primary mb-4"><i class="bi bi-clock-fill text-2xl"></i></div>
                <h3 class="font-bold mb-2">Operating Hours</h3>
                <p class="text-sm text-slate-200">{!! nl2br(e($hours)) !!}</p>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-slate-900 text-slate-400 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
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
                    <li><a href="#" class="hover:text-gold transition-colors">Home</a></li>
                    <li><a href="#about" class="hover:text-gold transition-colors">About Us</a></li>
                    <li><a href="#products" class="hover:text-gold transition-colors">Products</a></li>
                    <li><a href="#services" class="hover:text-gold transition-colors">Services</a></li>
                    <li><a href="#contact" class="hover:text-gold transition-colors">Contact</a></li>
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
        <hr class="border-slate-700 my-8">
        <div class="text-center text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>

</body>
</html>