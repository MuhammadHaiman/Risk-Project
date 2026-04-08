<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        h2 {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .agency-info {
            margin-bottom: 5px;
            font-size: 11px;
            color: #666;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #999;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>

    @forelse ($highestRisksByAgency as $agencyId => $data)
        <h2>{{ $data['agency']->nama_agensi }}</h2>
        <div class="agency-info">
            <strong>Sektor:</strong> {{ $data['agency']->sektor->nama ?? 'N/A' }}<br>
            <strong>Telefon:</strong> {{ $data['agency']->no_tel_agensi }}
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">Kedudukan</th>
                    <th style="width: 40%;">Risiko</th>
                    <th style="width: 35%;">Sub-Kategori</th>
                    <th style="width: 15%;">Kekerapan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['risks'] as $index => $risk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $risk->risiko->nama ?? 'N/A' }}</td>
                        <td>{{ $risk->risiko->subKategoriRisiko->nama ?? 'N/A' }}</td>
                        <td>{{ $risk->frequency }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-message">Tiada risiko didaftarkan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @empty
        <div class="empty-message">
            <p>Tiada data laporan untuk filter yang dipilih</p>
        </div>
    @endforelse
</body>

</html>
