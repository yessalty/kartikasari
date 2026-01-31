<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemasukan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f2f2f2;
        }
        .summary {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h2>LAPORAN PEMASUKAN VILLA</h2>

@if ($request->tanggal_awal && $request->tanggal_akhir)
    <p>
        Periode:
        {{ $request->tanggal_awal }} s/d {{ $request->tanggal_akhir }}
    </p>
@endif

<div class="summary">
    <strong>Total Pemasukan:</strong>
    Rp {{ number_format($totalPemasukan) }}
</div>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Villa</th>
            <th>Total</th>
            <th>DP</th>
            <th>Sisa</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemesanans as $p)
            <tr>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>{{ $p->villa->nama_villa }}</td>
                <td>Rp {{ number_format($p->total_harga) }}</td>
                <td>Rp {{ number_format($p->dp) }}</td>
                <td>Rp {{ number_format($p->sisa_pembayaran) }}</td>
                <td>{{ ucfirst($p->status_pemesanan) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
