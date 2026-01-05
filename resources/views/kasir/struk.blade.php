<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .center { text-align: center; }
        .right { text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
    </style>
</head>
<body>

<div class="center">
    <strong>TOKO FHATMA</strong><br>
    Jalan Raya No. 123<br>
    Telp: 0812-345-678
</div>

<div class="line"></div>

ID Transaksi : {{ $transaksi->id_transaksi }}<br>
Tanggal : {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y H:i') }}

<div class="line"></div>

<table>
@foreach ($detailTransaksi as $item)
<tr>
    <td>{{ $item->barang->nama_barang }}</td>
    <td class="right">{{ $item->jumlah }} x {{ number_format($item->barang->harga) }}</td>
</tr>
@endforeach
</table>

<div class="line"></div>

<table>
<tr>
    <td><strong>Total</strong></td>
    <td class="right"><strong>Rp {{ number_format($transaksi->total_bayar) }}</strong></td>
</tr>
<tr>
    <td>Bayar</td>
    <td class="right">Rp {{ number_format($transaksi->jumlah_bayar) }}</td>
</tr>
<tr>
    <td>Kembalian</td>
    <td class="right">Rp {{ number_format($transaksi->kembalian) }}</td>
</tr>
</table>

<div class="line"></div>

<div class="center">
    Terima kasih sudah berbelanja 🙏
</div>

</body>
</html>
