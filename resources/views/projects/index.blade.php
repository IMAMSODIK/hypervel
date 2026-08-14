<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects - {{ config('app.name') }}</title>
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
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-white text-slate-800">

@php
    $phone = \App\Models\Setting::get('contact_phone');
    $phone2 = \App\Models\Setting::get('contact_phone2');
    $email = \App\Models\Setting::get('contact_email');
    $hours = \App\Models\Setting::get('contact_hours');
    $facebook = \App\Models\Setting::get('contact_facebook');
    $linkedin = \App\Models\Setting::get('contact_linkedin');
    $instagram = \App\Models\Setting::get('contact_instagram');
    $youtube = \App\Models\Setting::get('contact_youtube');
    $heroVideo = \App\Models\Setting::get('hero_video');
    $categories = \App\Models\Project::where('is_active', true)->whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');
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
            @if($facebook)<a href="{{ $facebook }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-facebook"></i></a>@endif
            @if($linkedin)<a href="{{ $linkedin }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-linkedin"></i></a>@endif
            @if($instagram)<a href="{{ $instagram }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-instagram"></i></a>@endif
            @if($youtube)<a href="{{ $youtube }}" target="_blank" class="hover:text-gold transition-colors"><i class="bi bi-youtube"></i></a>@endif
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
            <a href="{{ url('/about') }}" class="hover:text-primary transition-colors">About</a>
            <a href="{{ url('/') }}#products" class="hover:text-primary transition-colors">Products</a>
            <a href="{{ url('/projects') }}" class="text-primary font-semibold">Projects</a>
            <a href="{{ url('/') }}#services" class="hover:text-primary transition-colors">Services</a>
            <a href="{{ url('/') }}#contact" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors font-semibold">Get a Quote</a>
        </div>
        <button class="md:hidden text-primary text-2xl" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
    </div>
    <div class="md:hidden hidden border-t border-slate-100" id="mobileMenu">
        <div class="flex flex-col gap-2 p-4 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="py-1 hover:text-primary">Home</a>
            <a href="{{ url('/about') }}" class="py-1 hover:text-primary">About</a>
            <a href="{{ url('/') }}#products" class="py-1 hover:text-primary">Products</a>
            <a href="{{ url('/projects') }}" class="py-1 text-primary font-semibold">Projects</a>
            <a href="{{ url('/') }}#services" class="py-1 hover:text-primary">Services</a>
            <a href="{{ url('/') }}#contact" class="py-1 hover:text-primary">Contact</a>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="relative w-full overflow-hidden" style="height:50vh; min-height:360px;">
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
            <span class="inline-block bg-gold text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-4">Portfolio</span>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 drop-shadow-lg">Our Projects</h1>
            <p class="text-lg text-slate-100 leading-relaxed drop-shadow max-w-2xl mx-auto">Explore a selection of industrial projects we have successfully delivered for our clients.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gold to-primary-light z-20"></div>
</section>

{{-- Category filter --}}
@if($categories->isNotEmpty())
<div class="bg-white border-b border-slate-100 sticky top-16 z-30">
    <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap gap-2 justify-center" id="categoryFilter">
        <button class="filter-btn active px-4 py-1.5 rounded-full text-sm font-medium transition-all" data-cat="all">All</button>
        @foreach($categories as $cat)
            <button class="filter-btn px-4 py-1.5 rounded-full text-sm font-medium transition-all" data-cat="{{ $cat }}">{{ $cat }}</button>
        @endforeach
    </div>
</div>
<style>
    .filter-btn { background:#f1f5f9; color:#475569; }
    .filter-btn:hover { background:#e2e8f0; }
    .filter-btn.active { background:#263C92; color:#fff; }
    .project-card { transition: opacity .3s, transform .3s; }
    .project-card.hidden-cat { display: none; }
</style>
@endif

{{-- Projects grid --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        @if($projects->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="projectsGrid">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}"
                   class="project-card group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col"
                   data-cat="{{ $project->category }}">
                    <div class="h-56 relative overflow-hidden">
                        @if($project->featured_image)
                            <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/60 via-transparent to-transparent"></div>
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                <i class="bi {{ $project->icon ?: 'bi-kanban' }} text-white/90 text-7xl group-hover:scale-110 transition-transform duration-500"></i>
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
                                @if($project->client)<span class="inline-flex items-center gap-1"><i class="bi bi-building"></i>{{ $project->client }}</span>@endif
                                @if($project->location)<span class="inline-flex items-center gap-1"><i class="bi bi-geo-alt"></i>{{ $project->location }}</span>@endif
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">{{ $projects->links() }}</div>
        @else
            <div class="text-center text-slate-400 py-20">No projects published yet.</div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="py-14 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h3 class="text-xl md:text-2xl font-bold text-primary mb-3">Have a project in mind?</h3>
        <p class="text-slate-600 mb-6">Let's discuss how we can help you achieve your goals.</p>
        <a href="{{ url('/') }}#contact" class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
            Contact Us <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

{{-- Footer --}}
@include('partials.footer')

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });

    // Category filter
    var filterBtns = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('.project-card');
    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            var cat = btn.dataset.cat;
            cards.forEach(function (card) {
                var show = cat === 'all' || card.dataset.cat === cat;
                card.classList.toggle('hidden-cat', !show);
            });
        });
    });
</script>

</body>
</html>