@extends('layout.layout')

@section('konten')
<div class="container">
    <h2>Laporan Penjualan Harian</h2>
    <p>Laporan untuk tanggal: <b>{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }}</b></p>

    <div class="card-group mb-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Penjualan</h5>
                <p class="card-text">Rp {{ number_format($totalPenjualan) }}</p>
            </div>
        </div>
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Keuntungan</h5>
                <p class="card-text">Rp {{ number_format($totalKeuntungan) }}</p>
            </div>
        </div>
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Jumlah Transaksi</h5>
                <p class="card-text">{{ $jumlahTransaksi }} transaksi</p>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <form action="{{ route('laporan.harian') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <label for="tanggal">Pilih Tanggal: &nbsp;</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Lihat Laporan</button>
        </form>
    </div>

    <h4>Daftar Transaksi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Waktu</th>
                <th>Total Bayar</th>
                <th>Keuntungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksiHariIni as $transaksi)
            <tr>
                <td>{{ $transaksi->id_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('H:i:s') }}</td>
                <td>Rp {{ number_format($transaksi->total_bayar) }}</td>
                <td>Rp {{ number_format($transaksi->total_keuntungan) }}</td>
                <td><a href="#" class="btn btn-sm btn-info">Lihat Detail</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada transaksi pada tanggal ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection