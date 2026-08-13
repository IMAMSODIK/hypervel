<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 480px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #00193c; padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700;">
                                {{ config('app.name') }}
                            </h1>
                            <p style="margin: 8px 0 0; color: #abc7ff; font-size: 14px;">
                                {{ config('app.description') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 16px; color: #111c2d; font-size: 16px; line-height: 1.6;">
                                Halo,
                            </p>
                            <p style="margin: 0 0 24px; color: #43474f; font-size: 15px; line-height: 1.6;">
                                Anda telah meminta untuk mereset kata sandi. Gunakan kode OTP berikut untuk melanjutkan:
                            </p>

                            <!-- OTP Code -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 0 24px;">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0; font-size: 36px; font-weight: 700; letter-spacing: 8px; color: #00193c; background-color: #f0f3ff; padding: 20px 32px; border-radius: 8px; border: 2px dashed #d7e2ff;">
                                            {{ $code }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 8px; color: #43474f; font-size: 14px; line-height: 1.6;">
                                Kode ini berlaku selama <strong style="color: #00193c;">15 menit</strong> dan hanya bisa digunakan satu kali.
                            </p>
                            <p style="margin: 0 0 24px; color: #43474f; font-size: 14px; line-height: 1.6;">
                                Berlaku hingga: <strong style="color: #00193c;">{{ $expiresAt }}</strong> WIB
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 16px 0; border-top: 1px solid #e2e8f0;">
                                        <p style="margin: 0; color: #747781; font-size: 13px; line-height: 1.5;">
                                            Jika Anda tidak meminta reset kata sandi, abaikan email ini. Kata sandi Anda tidak akan berubah.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9ff; padding: 24px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 4px; color: #00193c; font-size: 13px; font-weight: 600;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}
                            </p>
                            <p style="margin: 0; color: #747781; font-size: 12px;">
                                {{ config('app.description') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
