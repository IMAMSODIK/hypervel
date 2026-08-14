<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found - {{ config('app.name') }}</title>
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
        .error-code { font-size: clamp(6rem, 18vw, 12rem); line-height: 1; letter-spacing: -0.04em; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-800">

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
            <a href="{{ url('/projects') }}" class="hover:text-primary transition-colors">Projects</a>
            <a href="{{ url('/') }}#contact" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors font-semibold">Get a Quote</a>
        </div>
        <button class="md:hidden text-primary text-2xl" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
    </div>
    <div class="md:hidden hidden border-t border-slate-100" id="mobileMenu">
        <div class="flex flex-col gap-2 p-4 text-sm font-medium text-slate-600">
            <a href="{{ url('/') }}" class="py-1 hover:text-primary">Home</a>
            <a href="{{ url('/about') }}" class="py-1 hover:text-primary">About</a>
            <a href="{{ url('/') }}#products" class="py-1 hover:text-primary">Products</a>
            <a href="{{ url('/projects') }}" class="py-1 hover:text-primary">Projects</a>
            <a href="{{ url('/') }}#services" class="py-1 hover:text-primary">Services</a>
            <a href="{{ url('/') }}#contact" class="py-1 hover:text-primary">Contact</a>
            <a href="{{ url('/') }}#contact" class="bg-primary text-white px-4 py-2 rounded-lg text-center font-semibold">Get a Quote</a>
        </div>
    </div>
</nav>

{{-- 404 Content --}}
<main class="flex-grow flex items-center justify-center px-4 py-20 relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-gold/10 blur-3xl pointer-events-none"></div>

    <div class="text-center relative z-10 max-w-2xl mx-auto">

        <h1 class="error-code font-extrabold text-primary leading-none mb-2">404</h1>

        <div class="w-20 h-1 bg-gold mx-auto rounded-full mb-6"></div>

        <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-3">Page Not Found</h2>

        <p class="text-slate-500 leading-relaxed mb-8 max-w-md mx-auto">
            Oops! The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-primary text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                <i class="bi bi-house"></i> Back to Home
            </a>
            <a href="{{ url('/projects') }}" class="inline-flex items-center gap-2 border border-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">
                <i class="bi bi-grid"></i> Browse Projects
            </a>
        </div>

        {{-- Quick links --}}
        <div class="mt-12 pt-8 border-t border-slate-100">
            <p class="text-sm text-slate-400 mb-4">Or try one of these links:</p>
            <div class="flex flex-wrap gap-x-6 gap-y-2 justify-center text-sm">
                <a href="{{ url('/') }}#about" class="text-slate-500 hover:text-primary transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-building"></i> About Us
                </a>
                <span class="text-slate-200">|</span>
                <a href="{{ url('/') }}#products" class="text-slate-500 hover:text-primary transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <span class="text-slate-200">|</span>
                <a href="{{ url('/projects') }}" class="text-slate-500 hover:text-primary transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-kanban"></i> Projects
                </a>
                <span class="text-slate-200">|</span>
                <a href="{{ url('/') }}#services" class="text-slate-500 hover:text-primary transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-grid-1x2"></i> Services
                </a>
                <span class="text-slate-200">|</span>
                <a href="{{ url('/') }}#contact" class="text-slate-500 hover:text-primary transition-colors inline-flex items-center gap-1">
                    <i class="bi bi-telephone"></i> Contact
                </a>
            </div>
        </div>
    </div>
</main>

{{-- Footer --}}
@include('partials.footer')

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>

</body>
</html>