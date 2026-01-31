<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h3>Data Pengeluaran Villa</h3>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengeluaran as $row)
            <tr>
                <td>{{ $row->nama_pengeluaran }}</td>
                <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                <td>{{ $row->kategori_pengeluaran }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
