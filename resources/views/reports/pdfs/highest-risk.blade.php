<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #0066cc;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background-color: #0066cc;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f5f5f5;
        }

        table tbody tr:hover {
            background-color: #efefef;
        }

        .agency-header {
            background-color: #e6f0ff;
            font-weight: bold;
            color: #0066cc;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 12px;
        }

        .rank {
            background-color: #0066cc;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .frequency {
            background-color: #ffe6e6;
            color: #cc0000;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Laporan Risiko Tertinggi dalam Agensi</p>
        <p>Tarikh: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Risiko</th>
                <th style="width: 25%;">Sub-Kategori</th>
                <th style="width: 20%;">Kekerapan Didaftarkan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($highestRisks as $index => $item)
                <tr>
                    <td>
                        <div class="rank">{{ $index + 1 }}</div>
                    </td>
                    <td>{{ $item->risiko->nama ?? 'N/A' }}</td>
                    <td>{{ $item->risiko->subKategoriRisiko->nama ?? 'N/A' }}</td>
                    <td>
                        <div class="frequency">{{ $item->frequency }} kali</div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999;">Tiada data risiko tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dijana secara automatik oleh Sistem Pengurusan Risiko Quantum</p>
        <p>&copy; {{ date('Y') }} Risiko Quantum. Semua hak terpelihara.</p>
    </div>
</body>

</html>
