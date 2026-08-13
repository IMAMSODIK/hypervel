<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Forgot Password - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#e0e3e5",
                        "background": "#f9f9ff",
                        "primary-fixed": "#d7e2ff",
                        "secondary-container": "#d0e1fb",
                        "surface-tint": "#3e5e95",
                        "primary-fixed-dim": "#abc7ff",
                        "secondary-fixed": "#d3e4fe",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed": "#0b1c30",
                        "error-container": "#ffdad6",
                        "on-tertiary-container": "#939698",
                        "outline": "#747781",
                        "surface-container": "#e7eeff",
                        "surface-container-high": "#dee8ff",
                        "surface-dim": "#cfdaf2",
                        "error": "#ba1a1a",
                        "tertiary-container": "#2b2f31",
                        "surface-bright": "#f9f9ff",
                        "on-surface": "#111c2d",
                        "on-primary-container": "#7796d1",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#abc7ff",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "primary-container": "#002d62",
                        "surface-container-highest": "#d8e3fb",
                        "on-primary-fixed-variant": "#24467c",
                        "inverse-surface": "#263143",
                        "on-secondary-fixed-variant": "#38485d",
                        "on-tertiary": "#ffffff",
                        "on-background": "#111c2d",
                        "on-primary-fixed": "#001b3f",
                        "on-tertiary-fixed-variant": "#444749",
                        "secondary-fixed-dim": "#b7c8e1",
                        "on-tertiary-fixed": "#191c1e",
                        "outline-variant": "#c4c6d1",
                        "on-surface-variant": "#43474f",
                        "surface-container-low": "#f0f3ff",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#54647a",
                        "secondary": "#505f76",
                        "inverse-on-surface": "#ecf1ff",
                        "surface-variant": "#d8e3fb",
                        "primary": "#00193c",
                        "surface": "#f9f9ff",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "tertiary": "#171a1c"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max": "1200px",
                        "sm": "1rem",
                        "lg": "2rem",
                        "gutter": "1.5rem",
                        "xs": "0.5rem",
                        "md": "1.5rem",
                        "base": "4px",
                        "margin-mobile": "1rem",
                        "xl": "3rem"
                    },
                    "fontFamily": {
                        "headline-md": ["Inter"],
                        "body-sm": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "label-md": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["30px", {
                            "lineHeight": "38px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "label-sm": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.02em",
                            "fontWeight": "500"
                        }],
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "700"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }]
                    }
                },
            },
        }
    </script>
    <link rel="stylesheet" href="{{ asset('auth_assets/style.css') }}">
</head>

<body class="min-h-screen flex flex-col">
    <header
        class="bg-surface border-b border-outline-variant flex justify-between items-center w-full px-margin-mobile md:px-gutter h-24 md:h-24 fixed top-0 left-0 z-50">
        <div class="flex items-center cursor-pointer active:opacity-80">
            <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}"
                class="h-20 w-auto md:h-20 lg:h-20 object-contain shrink-0">
        </div>
        <div class="flex flex-col leading-tight text-right">
            <span class="hidden md:block font-headline-md text-headline-md text-primary font-bold">
                {{ config('app.name') }}
            </span>
            <span class="md:hidden font-headline-md text-headline-md-mobile text-primary font-bold">
                {{ config('app.name') }}
            </span>
            <span class="text-[11px] md:text-xs text-gray-500 font-medium">
                {{ config('app.description') }}
            </span>
        </div>
    </header>

    <main class="flex-grow flex flex-col md:flex-row pt-12 md:pt-14 overflow-hidden">
        <div class="hidden md:block md:w-1/2 lg:w-[60%] relative bg-primary-container overflow-hidden">
            <div class="absolute inset-0 z-10 bg-gradient-to-t from-primary-container/60 to-transparent"></div>
            <div class="absolute bottom-xl left-xl z-20 text-white max-w-lg">
                <h2 class="font-headline-lg text-white mb-sm">
                    Forgot Password?
                </h2>
                <p class="font-body-md opacity-90">
                    Don't worry. Enter your email and we'll send you an OTP code to reset
                    your password.
                </p>
            </div>
            <div class="absolute inset-0" id="carousel">
                @foreach ($sliderItems as $index => $slide)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }} absolute inset-0">
                        <img alt="{{ $slide->judul ?? 'Slide' }}" class="w-full h-full object-cover"
                            src="{{ $slide->gambar_url }}" />
                    </div>
                @endforeach
            </div>
        </div>

        <div
            class="w-full md:w-1/2 lg:w-[40%] flex items-center justify-center p-margin-mobile md:p-xl bg-background overflow-y-auto">
            <div class="w-full max-w-[400px]">
                <div class="mb-lg text-center md:text-left">
                    <div
                        class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-primary-fixed-dim mb-sm">
                        <span class="material-symbols-outlined text-primary text-[32px]">
                            lock_reset
                        </span>
                    </div>
                    <h1 class="font-headline-lg-mobile md:text-headline-lg text-primary mb-xs">Forgot Password</h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Enter your email to receive an OTP code</p>
                </div>

                <form class="space-y-md" id="forgotForm" onsubmit="return false">
                    @csrf
                    <div class="space-y-base">
                        <label class="font-label-md text-label-md text-on-surface" for="email">Email</label>
                        <div class="relative">
                            <span
                                class="absolute left-sm top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-[20px]"
                                data-icon="mail">mail</span>
                            <input
                                class="w-full h-[48px] pl-xl pr-sm bg-white border border-outline-variant rounded-lg font-body-sm text-body-sm input-focus-ring transition-all"
                                id="email" name="email" placeholder="name@company.com" required=""
                                type="email" autocomplete="email" />
                        </div>
                    </div>

                    <button
                        class="w-full h-[48px] bg-primary text-white font-label-md text-label-md rounded-lg hover:opacity-90 active:opacity-80 transition-all flex items-center justify-center gap-xs"
                        type="submit" id="sendOtpBtn">
                        Send OTP Code
                        <span class="material-symbols-outlined text-[18px]" data-icon="send">send</span>
                    </button>
                </form>

                <div class="hidden mt-md p-sm bg-error-container border border-error/20 rounded-lg flex items-center gap-xs"
                    id="errorMessage">
                    <span class="material-symbols-outlined text-error text-[20px]" data-icon="error">error</span>
                    <p class="font-body-sm text-body-sm text-on-error-container" id="errorText">An error occurred.</p>
                </div>

                <div class="mt-lg text-center">
                    <a href="{{ route('login') }}"
                        class="font-label-sm text-label-sm text-primary hover:underline transition-all inline-flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[16px]" data-icon="arrow_back">arrow_back</span>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer
        class="bg-surface border-t border-outline-variant w-full py-md px-margin-mobile md:px-gutter relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <div class="md:col-span-6 text-center md:text-left">
                <p class="font-body-sm text-body-sm text-primary font-bold mb-1">
                    {{ config('app.name') }}
                </p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    &copy; {{ date('Y') }} All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Carousel
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-item');
        function nextSlide() {
            if (slides.length === 0) return;
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, 5000);

        // Forgot Password Form
        const forgotForm = document.getElementById('forgotForm');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');

        forgotForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = document.getElementById('sendOtpBtn');
            const originalContent = btn.innerHTML;

            errorMessage.classList.add('hidden');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin" data-icon="progress_activity">progress_activity</span> Sending...';

            const formData = new FormData(forgotForm);

            fetch('{{ route("send-otp") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token'),
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalContent;

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    errorText.textContent = data.message;
                    errorMessage.classList.remove('hidden');
                    const formContainer = document.querySelector('main .w-full.max-w-\\[400px\\]');
                    formContainer.classList.add('animate-shake');
                    setTimeout(() => formContainer.classList.remove('animate-shake'), 500);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                errorText.textContent = 'A network error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            });
        });
    </script>
</body>

</html>
