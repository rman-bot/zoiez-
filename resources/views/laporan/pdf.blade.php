<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan & Transaksi - Zoiez Motor</title>
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
        
        /* Summary Widgets Table */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .summary-table td {
            width: 25%;
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
        .laba-positif {
            color: #15803d;
        }
        .laba-negatif {
            color: #b91c1c;
        }
        
        /* Asset Valuation Box */
        .asset-box {
            background-color: #1e293b;
            color: #ffffff;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .asset-box h3 {
            margin: 0 0 8px 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
        }
        .asset-grid {
            width: 100%;
        }
        .asset-grid td {
            width: 33.33%;
            border: none;
            color: #ffffff;
            padding: 0;
        }
        .asset-grid td span {
            font-size: 13px;
            font-weight: bold;
        }
        .asset-grid td .label {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }
        
        /* Main Transaction Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
        
        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-masuk {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .badge-keluar {
            background-color: #ffe4e6;
            color: #b91c1c;
            border: 1px solid #fecdd3;
        }
        
        /* Signatures Section */
        .signatures {
            width: 100%;
            margin-top: 40px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            border: none;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Zoiez Motor</h1>
        <h2>Laporan Transaksi &amp; Keuangan Inventaris</h2>
        <p>
            Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
            &nbsp;|&nbsp;
            Filter Transaksi: <strong>{{ $type }}</strong>
            &nbsp;|&nbsp;
            Tanggal Cetak: <strong>{{ now()->format('d/m/Y H:i') }}</strong>
        </p>
    </div>

    <!-- Summary Cards -->
    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-title">Total Pembelian</span>
                <span class="summary-value">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="summary-title">Total Penjualan</span>
                <span class="summary-value" style="color: #2563eb;">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="summary-title">HPP (Harga Pokok)</span>
                <span class="summary-value" style="color: #d97706;">Rp {{ number_format($totalHpp, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="summary-title">Laba Kotor</span>
                <span class="summary-value {{ $labaKotor >= 0 ? 'laba-positif' : 'laba-negatif' }}">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>

    <!-- Valuation Box -->
    <div class="asset-box">
        <h3 style="color: #94a3b8; font-size: 10px; margin-bottom: 6px;">Valuasi Aset Inventaris Terkini (Stok Gudang)</h3>
        <table class="asset-grid">
            <tr>
                <td>
                    <span class="label">Total Item Tersedia</span>
                    <span>{{ number_format($totalStok) }} Unit</span>
                </td>
                <td>
                    <span class="label">Total Aset (Nilai Beli)</span>
                    <span style="color: #4ade80;">Rp {{ number_format($totalAsetBeli, 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="label">Total Aset (Nilai Jual)</span>
                    <span style="color: #60a5fa;">Rp {{ number_format($totalAsetJual, 0, ',', '.') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Transactions List -->
    <table class="main-table">
        <thead>
            <tr>
                <th width="8%" class="text-center">Tanggal</th>
                <th width="32%">Kode &amp; Nama Sparepart</th>
                <th width="10%" class="text-center">Jenis</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="15%" class="text-right">Harga Satuan</th>
                <th width="15%" class="text-right">Total Nilai</th>
                <th width="10%">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
                <tr>
                    <td class="text-center">{{ $tx->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <div class="bold">{{ $tx->sparepart->nama_sparepart }}</div>
                        <div style="color: #666666; font-size: 8px;">
                            {{ $tx->sparepart->kode_sparepart }} &bull; {{ $tx->sparepart->kategori->nama_kategori }}
                            @if($tx->jenis === 'Keluar' && $tx->atas_nama)
                                &bull; <span style="color: #2563eb; font-weight: bold;">A.n. {{ $tx->atas_nama }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        @if($tx->jenis === 'Masuk')
                            <span class="badge badge-masuk">Masuk</span>
                        @else
                            <span class="badge badge-keluar">Keluar</span>
                        @endif
                    </td>
                    <td class="text-center bold" style="color: {{ $tx->jenis === 'Masuk' ? '#15803d' : '#b91c1c' }};">
                        {{ $tx->jenis === 'Masuk' ? '+' : '-' }}{{ $tx->jumlah }} {{ $tx->sparepart->satuan }}
                    </td>
                    <td class="text-right">
                        @if($tx->jenis === 'Masuk')
                            Rp {{ number_format($tx->harga_beli, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($tx->sparepart->harga_jual, 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="text-right bold" style="color: {{ $tx->jenis === 'Masuk' ? '#333333' : '#1d4ed8' }};">
                        @if($tx->jenis === 'Masuk')
                            Rp {{ number_format($tx->harga_total, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($tx->jumlah * $tx->sparepart->harga_jual, 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-style: italic; color: #666666;">{{ $tx->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #777777;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signatures -->
    <table class="signatures">
        <tr>
            <td>
                <p>Laporan Dibuat Oleh,</p>
                <div class="signature-space"></div>
                <p><strong>Admin Inventaris</strong></p>
                <p style="font-size: 8px; color: #777777; margin: 0;">Zoiez Motor</p>
            </td>
            <td>
                <p>Mengetahui / Menyetujui,</p>
                <div class="signature-space"></div>
                <p><strong>Pemilik / Manajer</strong></p>
                <p style="font-size: 8px; color: #777777; margin: 0;">Zoiez Motor</p>
            </td>
        </tr>
    </table>

</body>
</html>
