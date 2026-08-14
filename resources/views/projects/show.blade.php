<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }} - {{ config('app.name') }}</title>
    @if ($project->meta_description)
        <meta name="description" content="{{ $project->meta_description }}">
    @endif
    @if ($project->meta_keywords)
        <meta name="keywords" content="{{ $project->meta_keywords }}">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#263C92',
                            light: '#3a54b0',
                            dark: '#1d2d6e'
                        },
                        gold: {
                            DEFAULT: '#DFB624',
                            light: '#e8c64a',
                            dark: '#c49e1a'
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .rich-content {
            line-height: 1.8;
            color: #334155;
        }

        .rich-content h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            margin: 1.5rem 0 0.75rem;
        }

        .rich-content h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 1.5rem 0 0.75rem;
        }

        .rich-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin: 1.25rem 0 0.5rem;
        }

        .rich-content h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin: 1rem 0 0.5rem;
        }

        .rich-content p {
            margin-bottom: 1rem;
        }

        .rich-content ul {
            list-style: disc;
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .rich-content ol {
            list-style: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .rich-content li {
            margin-bottom: 0.25rem;
        }

        .rich-content blockquote {
            border-left: 4px solid #DFB624;
            padding: 0.5rem 1rem;
            margin: 1rem 0;
            background: #f8fafc;
            color: #475569;
        }

        .rich-content a {
            color: #263C92;
            text-decoration: underline;
        }

        .rich-content a:hover {
            color: #1d2d6e;
        }

        .rich-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 1rem 0;
        }

        .rich-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
        }

        .rich-content th,
        .rich-content td {
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            text-align: left;
            white-space: nowrap;
        }

        .rich-content thead,
        .rich-content tbody,
        .rich-content tr {
            display: table;
            width: 100%;
            table-layout: auto;
        }

        .rich-content th {
            background: #f1f5f9;
            font-weight: 600;
        }

        .rich-content hr {
            border: 0;
            border-top: 1px solid #e2e8f0;
            margin: 2rem 0;
        }

        .rich-content code {
            background: #f1f5f9;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }

        .rich-content pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .gallery-thumb {
            cursor: pointer;
            transition: all .25s;
        }

        .gallery-thumb.active {
            ring: 2px solid #DFB624;
            box-shadow: 0 0 0 2px #DFB624;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease forwards;
        }
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
        $heroVideo = \App\Models\Setting::get('hero_video');
    @endphp

    {{-- Top Contact Bar --}}
    <div class="bg-primary text-white text-sm py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
                @if ($phone)
                    <a href="tel:{{ $phone }}"
                        class="inline-flex items-center gap-1.5 hover:text-gold transition-colors">
                        <i class="bi bi-telephone-fill text-gold text-xs"></i>{{ $phone }}
                    </a>
                @endif
                @if ($email)
                    <a href="mailto:{{ $email }}"
                        class="inline-flex items-center gap-1.5 hover:text-gold transition-colors">
                        <i class="bi bi-envelope-fill text-gold text-xs"></i>{{ $email }}
                    </a>
                @endif
                @if ($hours)
                    <span class="inline-flex items-center gap-1.5">
                        <i class="bi bi-clock-fill text-gold text-xs"></i>{{ $hours }}
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if ($facebook)
                    <a href="{{ $facebook }}" target="_blank" class="hover:text-gold transition-colors"><i
                            class="bi bi-facebook"></i></a>
                @endif
                @if ($linkedin)
                    <a href="{{ $linkedin }}" target="_blank" class="hover:text-gold transition-colors"><i
                            class="bi bi-linkedin"></i></a>
                @endif
                @if ($instagram)
                    <a href="{{ $instagram }}" target="_blank" class="hover:text-gold transition-colors"><i
                            class="bi bi-instagram"></i></a>
                @endif
                @if ($youtube)
                    <a href="{{ $youtube }}" target="_blank" class="hover:text-gold transition-colors"><i
                            class="bi bi-youtube"></i></a>
                @endif
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-1 bg-gold text-primary font-semibold px-3 py-1 rounded hover:opacity-90 transition-opacity">
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
                <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}"
                    class="h-10 w-auto object-contain">
                <div class="flex flex-col leading-tight">
                    <span class="font-bold text-base text-primary">{{ config('app.name') }}</span>
                    <span class="text-xs text-slate-400">{{ config('app.description') }}</span>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
                <a href="{{ url('/about') }}" class="hover:text-primary transition-colors">About</a>
                <a href="{{ url('/') }}#projects" class="text-primary font-semibold">Projects</a>
                <a href="{{ url('/') }}#services" class="hover:text-primary transition-colors">Services</a>
                <a href="{{ url('/') }}#contact" class="hover:text-primary transition-colors">Contact</a>
                <a href="{{ url('/') }}#contact"
                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors font-semibold">Get
                    a Quote</a>
            </div>
            <button class="md:hidden text-primary text-2xl" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
        </div>
        <div class="md:hidden hidden border-t border-slate-100" id="mobileMenu">
            <div class="flex flex-col gap-2 p-4 text-sm font-medium text-slate-600">
                <a href="{{ url('/') }}" class="py-1 hover:text-primary">Home</a>
                <a href="{{ url('/about') }}" class="py-1 hover:text-primary">About</a>
                <a href="{{ url('/') }}#projects" class="py-1 text-primary font-semibold">Projects</a>
                <a href="{{ url('/') }}#services" class="py-1 hover:text-primary">Services</a>
                <a href="{{ url('/') }}#contact" class="py-1 hover:text-primary">Contact</a>
                <a href="{{ url('/') }}#contact"
                    class="bg-primary text-white px-4 py-2 rounded-lg text-center font-semibold">Get a Quote</a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative w-full overflow-hidden" style="height:60vh; min-height:420px;">
        @if ($heroVideo)
            <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline
                preload="metadata" poster="{{ asset('auth_assets/logo/logo.png') }}">
                <source src="{{ str_starts_with($heroVideo, 'http') ? $heroVideo : asset('storage/' . $heroVideo) }}"
                    type="video/mp4">
            </video>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-primary-light to-primary-dark"></div>
        @endif
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 h-full flex items-center justify-center">
            <div class="max-w-3xl mx-auto px-4 text-center text-white">
                <span
                    class="inline-block bg-gold text-primary text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-4">Project</span>
                <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4 drop-shadow-lg">{{ $project->title }}
                </h1>
                @if ($project->short_description)
                    <p class="text-lg text-slate-100 mb-8 leading-relaxed drop-shadow max-w-2xl mx-auto">
                        {{ $project->short_description }}</p>
                @endif
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="#project-detail"
                        class="bg-gold text-primary font-semibold px-6 py-3 rounded-lg hover:opacity-90 transition-opacity inline-flex items-center gap-2">
                        View Details <i class="bi bi-arrow-down"></i>
                    </a>
                    <a href="{{ route('projects.index') }}"
                        class="border border-white/40 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10 transition-colors inline-flex items-center gap-2 backdrop-blur-sm">
                        <i class="bi bi-grid"></i> All Projects
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gold to-primary-light z-20"></div>
    </section>

    {{-- Breadcrumb --}}
    <div class="bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 py-3 text-sm text-slate-500 flex flex-wrap items-center gap-2">
            <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Home</a>
            <i class="bi bi-chevron-right text-xs text-slate-300"></i>
            <a href="{{ url('/') }}#projects" class="hover:text-primary transition-colors">Projects</a>
            <i class="bi bi-chevron-right text-xs text-slate-300"></i>
            <span class="text-slate-700 font-medium truncate">{{ $project->title }}</span>
        </div>
    </div>

    {{-- Project Detail --}}
    <section id="project-detail" class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

                {{-- Left: Images --}}
                <div class="lg:sticky lg:top-24 lg:self-start">
                    @php
                        $mainImage = $project->featured_image
                            ? $project->featured_image_url
                            : ($project->images->isNotEmpty()
                                ? $project->images->first()->image_url
                                : null);
                    @endphp
                    <div class="relative rounded-2xl overflow-hidden shadow-xl bg-slate-100"
                        style="aspect-ratio:4/3;">
                        @if ($mainImage)
                            <img src="{{ $mainImage }}" alt="{{ $project->title }}" id="mainProjectImage"
                                class="w-full h-full object-cover transition-all duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center"
                                style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                @if ($project->icon)
                                    <i class="bi {{ $project->icon }} text-white/90 text-8xl"></i>
                                @else
                                    <i class="bi bi-image text-white/30 text-8xl"></i>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Gallery thumbnails --}}
                    @if ($project->images->count() > 0 || $project->featured_image)
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2" id="galleryThumbs">
                            @if ($project->featured_image)
                                <button
                                    class="gallery-thumb active shrink-0 rounded-lg overflow-hidden border-2 border-transparent"
                                    data-src="{{ $project->featured_image_url }}">
                                    <img src="{{ $project->featured_image_url }}" alt="Featured"
                                        class="w-20 h-20 object-cover">
                                </button>
                            @endif
                            @foreach ($project->images as $img)
                                <button
                                    class="gallery-thumb shrink-0 rounded-lg overflow-hidden border-2 border-transparent @if (!$project->featured_image && $loop->first) active @endif"
                                    data-src="{{ $img->image_url }}">
                                    <img src="{{ $img->image_url }}" alt="Gallery" class="w-20 h-20 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Right: Content --}}
                <div class="animate-fade-up">
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-3">Project Overview</h2>
                    <div class="w-16 h-1 bg-gold rounded-full mb-6"></div>

                    {{-- Project meta info box --}}
                    @if ($project->category || $project->client || $project->location || $project->year)
                        <div
                            class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            @if ($project->category)
                                <div>
                                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-0.5">
                                        Category</div>
                                    <div class="text-sm font-medium text-slate-700">{{ $project->category }}</div>
                                </div>
                            @endif
                            @if ($project->client)
                                <div>
                                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-0.5">
                                        Client</div>
                                    <div class="text-sm font-medium text-slate-700">{{ $project->client }}</div>
                                </div>
                            @endif
                            @if ($project->location)
                                <div>
                                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-0.5">
                                        Location</div>
                                    <div class="text-sm font-medium text-slate-700">{{ $project->location }}</div>
                                </div>
                            @endif
                            @if ($project->year)
                                <div>
                                    <div class="text-xs text-slate-400 uppercase tracking-wide font-semibold mb-0.5">
                                        Year</div>
                                    <div class="text-sm font-medium text-slate-700">{{ $project->year }}</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($project->short_description)
                        <p class="text-lg text-slate-600 leading-relaxed mb-6">{{ $project->short_description }}</p>
                    @endif

                    {{-- CTA --}}
                    <div class="flex flex-wrap gap-3 mb-8">
                        <a href="{{ url('/') }}#contact"
                            class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="bi bi-telephone"></i> Request a Quote
                        </a>
                        <a href="{{ url('/') }}#contact"
                            class="inline-flex items-center gap-2 border border-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">
                            <i class="bi bi-envelope"></i> Enquire
                        </a>
                    </div>

                    {{-- Rich text content --}}
                    @if ($project->content)
                        <div class="rich-content border-t border-slate-100 pt-6">{!! $project->content !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Related Projects --}}
    @if ($related->isNotEmpty())
        <section class="bg-slate-50 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-10">
                    <span class="text-gold font-semibold uppercase tracking-wider text-sm">Explore More</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mt-1">Related Projects</h2>
                    <div class="w-16 h-1 bg-gold rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($related as $rel)
                        <a href="{{ route('projects.show', $rel->slug) }}"
                            class="group bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="h-40 overflow-hidden relative">
                                @if ($rel->featured_image)
                                    <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"
                                        style="background:linear-gradient(135deg,#263C92,#1d2d6e);">
                                        <i class="bi {{ $rel->icon ?: 'bi-kanban' }} text-white/90 text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-slate-800 group-hover:text-primary transition-colors">
                                    {{ $rel->title }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ $rel->short_description }}</p>
                                <span
                                    class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-primary group-hover:gap-2.5 transition-all">
                                    View Details <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA Section --}}
    <section class="py-14 bg-white">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-primary mb-3">Need more information?</h3>
            <p class="text-slate-600 mb-6">Our team is ready to help you find the right solution for your needs.</p>
            <a href="{{ url('/') }}#contact"
                class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                Contact Us <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    @include('partials.footer')

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu')?.classList.toggle('hidden');
        });

        // Gallery thumbnail switcher
        var mainImg = document.getElementById('mainProjectImage');
        document.querySelectorAll('.gallery-thumb').forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                document.querySelectorAll('.gallery-thumb').forEach(function(t) {
                    t.classList.remove('active');
                });
                thumb.classList.add('active');
                if (mainImg) {
                    mainImg.style.opacity = '0';
                    setTimeout(function() {
                        mainImg.src = thumb.dataset.src;
                        mainImg.style.opacity = '1';
                    }, 200);
                }
            });
        });
    </script>

</body>

</html>
