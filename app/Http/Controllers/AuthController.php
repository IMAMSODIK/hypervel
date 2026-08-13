<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('auth.login', $this->sharedViewData());
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect' => url('/'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password', $this->sharedViewData());
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Email is not registered in the system.',
            ], 422);
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(15);

        Cache::put('otp:'.$validated['email'], $otp, now()->addMinutes(15));

        try {
            Mail::send('emails.otp', [
                'code' => $otp,
                'expiresAt' => $expiresAt->format('H:i'),
            ], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Password Reset OTP Code');
            });
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'success' => true,
            'redirect' => route('verify-otp', ['email' => $validated['email']]),
        ]);
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->query('email');

        if (! $email || ! Cache::has('otp:'.$email)) {
            return redirect()->route('forgot-password');
        }

        return view('auth.verify-otp', array_merge($this->sharedViewData(), ['email' => $email]));
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $cached = Cache::get('otp:'.$validated['email']);

        if (! $cached || ! hash_equals((string) $cached, (string) $validated['otp'])) {
            return response()->json([
                'success' => false,
                'message' => 'The OTP code is incorrect or has expired.',
            ], 422);
        }

        $token = Str::random(64);
        Cache::put('reset:'.$validated['email'], $token, now()->addMinutes(15));
        Cache::forget('otp:'.$validated['email']);

        return response()->json([
            'success' => true,
            'redirect' => route('reset-password', ['email' => $validated['email'], 'token' => $token]),
        ]);
    }

    public function showResetPassword(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (! $email || ! $token || ! Cache::has('reset:'.$email)) {
            return redirect()->route('forgot-password');
        }

        return view('auth.reset-password', array_merge($this->sharedViewData(), [
            'email' => $email,
            'token' => $token,
        ]));
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $cachedToken = Cache::get('reset:'.$validated['email']);

        if (! $cachedToken || ! hash_equals((string) $cachedToken, (string) $validated['token'])) {
            return response()->json([
                'success' => false,
                'message' => 'The reset token is invalid or has expired.',
            ], 422);
        }

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        Cache::forget('reset:'.$validated['email']);

        return response()->json([
            'success' => true,
            'redirect' => route('login'),
        ]);
    }

    private function sharedViewData(): array
    {
        return [
            'sliderItems' => $this->sliderItems(),
        ];
    }

    private function sliderItems()
{
    $items = [
        ['judul' => 'Distributor Valve & Aktuator Industri', 'gambar' => 'auth_assets/logo/logo.png'],
        ['judul' => 'Solusi Perpipaan & Otomasi Valve', 'gambar' => 'auth_assets/logo/logo.png'],
    ];

    return collect($items)->map(fn ($item) => (object) [
        'judul' => $item['judul'],
        'gambar_url' => asset($item['gambar']),
    ]);
}
}