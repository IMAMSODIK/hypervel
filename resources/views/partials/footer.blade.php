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
    $mapEmbed = \App\Models\Setting::get('contact_map_embed');
    $aboutSubtitle = \App\Models\Setting::get('about_subtitle');
@endphp

<footer class="bg-slate-900 text-slate-400 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('auth_assets/logo/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
                </div>
                <p class="text-sm">{{ config('app.description') }}</p>
                @if($aboutSubtitle)
                    <p class="text-sm text-slate-400 mt-2 leading-relaxed">{{ $aboutSubtitle }}</p>
                @endif
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
                    <li><a href="{{ url('/') }}#products" class="hover:text-gold transition-colors">Products</a></li>
                    @php $projRoute = Route::has('projects.index') ? route('projects.index') : url('/projects'); @endphp
                    <li><a href="{{ $projRoute }}" class="hover:text-gold transition-colors">Projects</a></li>
                    <li><a href="{{ url('/') }}#services" class="hover:text-gold transition-colors">Services</a></li>
                    <li><a href="{{ url('/') }}#contact" class="hover:text-gold transition-colors">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-white mb-4">Contact</h4>
                <ul class="space-y-2 text-sm">
                    @if($phone)<li><i class="bi bi-telephone me-2"></i>{{ $phone }}</li>@endif
                    @if($phone2)<li><i class="bi bi-telephone me-2"></i>{{ $phone2 }}</li>@endif
                    @if($email)<li><i class="bi bi-envelope me-2"></i>{{ $email }}</li>@endif
                    @if($address)<li><i class="bi bi-geo-alt me-2"></i>{!! nl2br(e($address)) !!}</li>@endif
                    @if($hours)<li><i class="bi bi-clock me-2"></i>{{ $hours }}</li>@endif
                </ul>
                @if($mapEmbed)
                    <div class="mt-4 rounded-lg overflow-hidden border border-slate-700" style="height:200px;">
                        {!! $mapEmbed !!}
                    </div>
                    <style>footer iframe { width:100% !important; height:200px !important; border:0 !important; display:block; }</style>
                @endif
            </div>
        </div>
        <hr class="border-slate-700 my-8">
        <div class="text-center text-sm">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>