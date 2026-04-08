<!-- Main Email Container -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .body {
            padding: 30px 20px;
            line-height: 1.6;
        }

        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #f0f4f8;
            border-left: 4px solid #1e40af;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-box strong {
            color: #1e40af;
        }

        .details {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .details p {
            margin: 8px 0;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #1e40af;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #1e3a8a;
        }

        .footer {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e5e7eb;
        }

        .footer a {
            color: #1e40af;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🔐 {{ $appName }}</h1>
            <p style="margin: 5px 0;">Akaun Baru Telah Dibuat</p>
        </div>

        <div class="body">
            <div class="greeting">Selamat Datang, {{ $user->name }}!</div>

            <p>Akaun anda telah berjaya didaftarkan dalam Sistem Pengurusan Risiko Quantum dengan peranan sebagai
                <strong>{{ $role }}</strong>.</p>

            <div class="info-box">
                <strong>📧 Email Anda:</strong><br>
                {{ $user->email }}
            </div>

            <div class="details">
                <p><strong>Maklumat Akaun:</strong></p>
                <p>• <strong>Nama:</strong> {{ $user->name }}</p>
                <p>• <strong>Peranan:</strong> {{ $role }}</p>
                <p>• <strong>Status:</strong> Aktif ✓</p>
            </div>

            <p style="margin-top: 20px;">Anda kini boleh log masuk ke sistem menggunakan email dan kata laluan yang
                telah anda daftar.</p>

            <a href="{{ $appUrl }}" class="button">Log Masuk ke Sistem</a>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <p style="font-size: 14px; color: #666;">
                    <strong>Sekiranya anda mengalami sebarang masalah,</strong><br>
                    Sila hubungi pasukan sokongan kami untuk bantuan lanjut.
                </p>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0;">© 2026 Sistem Pengurusan Risiko Quantum. Semua hak terpelihara.</p>
            <p style="margin: 5px 0; font-size: 11px;">Email ini telah dihantar kepada {{ $user->email }}</p>
        </div>
    </div>
</body>

</html>
