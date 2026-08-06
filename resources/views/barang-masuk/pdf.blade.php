<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Masuk - Zoiez Motor</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
            color: #111111;
        }
        .header h2 {
            font-size: 14px;
            margin: 5px 0 0 0;
            color: #444444;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #666666;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .summary-table td {
            width: 50%;
            padding: 10px;
            border: 1px solid #dddddd;
            background-color: #fafafa;
            vertical-align: top;
        }
        .summary-title {
            font-size: 8px;
            text-transform: uppercase;
            color: #777777;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #111111;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
            text-align: left;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 9px;
            text-transform: uppercase;
        }
        .main-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 9px;
            vertical-align: middle;
        }
        .main-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Zoiez Motor</h1>
        <h2>Laporan Transaksi Barang Masuk</h2>
        <p>
            @if($startDate && $endDate)
                Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
            @else
                Periode: <strong>Semua Transaksi</strong>
            @endif
            &nbsp;|&nbsp;
            Tanggal Cetak: <strong>{{ now()->format('d/m/Y H:i') }}</strong>
        </p>
    </div>

    <!-- Summary -->
    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-title">Total Transaksi Barang Masuk</span>
                <span class="summary-value">{{ number_format($incomingLogs->count()) }} Transaksi</span>
            </td>
            <td>
                <span class="summary-title">Total Biaya Beli (Restok)</span>
                <span class="summary-value" style="color: #15803d;">Rp {{ number_format($incomingLogs->sum('harga_total'), 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th width="12%" class="text-center">Tanggal</th>
                <th width="12%">Kode</th>
                <th width="28%">Nama Sparepart</th>
                <th width="15%">Kategori</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="13%" class="text-right">Harga Beli</th>
                <th width="15%" class="text-right">Harga Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incomingLogs as $log)
                <tr>
                    <td class="text-center">{{ $log->tanggal->format('d/m/Y') }}</td>
                    <td class="bold">{{ $log->sparepart->kode_sparepart }}</td>
                    <td>{{ $log->sparepart->nama_sparepart }}</td>
                    <td>{{ $log->sparepart->kategori->nama_kategori }}</td>
                    <td class="text-center bold" style="color: #15803d;">
                        +{{ $log->jumlah }} {{ $log->sparepart->satuan }}
                    </td>
                    <td class="text-right">
                        @if($log->harga_beli > 0)
                            Rp {{ number_format($log->harga_beli, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right bold" style="color: #2563eb;">
                        @if($log->harga_total > 0)
                            Rp {{ number_format($log->harga_total, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #777777;">Tidak ada data barang masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
