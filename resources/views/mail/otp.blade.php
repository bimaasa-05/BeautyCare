<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode Verifikasi - BeautyCare</title>
</head>
<body style="margin:0;padding:0;background:#F8F5F2;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,.08);">
                    <tr>
                        <td align="center" style="background:linear-gradient(135deg,#FF4F87,#FF7BA6);padding:32px 24px;">
                            <h1 style="margin:0;color:#fff;font-size:22px;">Kode Verifikasi Akun BeautyCare</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 24px;text-align:center;">
                            <p style="margin:0 0 16px;color:#555;font-size:15px;line-height:1.6;">
                                Gunakan kode berikut untuk menyelesaikan verifikasi email Anda:
                            </p>
                            <p style="margin:0 0 16px;font-size:36px;font-weight:bold;letter-spacing:8px;color:#FF4F87;">
                                {{ $otp }}
                            </p>
                            <p style="margin:0;color:#888;font-size:13px;">
                                Kode berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapa pun.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 24px;background:#FAFAFA;text-align:center;">
                            <p style="margin:0;color:#aaa;font-size:12px;">&copy; {{ date('Y') }} BeautyCare</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>