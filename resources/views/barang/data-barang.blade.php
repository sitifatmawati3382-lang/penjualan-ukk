@extends('layout.layout') {{-- Pastikan path ke layout Anda benar, e.g., 'layouts.app' atau 'layout.layout' --}}

@section('konten') {{-- Ini adalah nama section yang Anda gunakan di layout Anda --}}

    <div class="card m-2">
        <div class="card-header">
            <h1>Data Barang</h1>
        </div>
        <div class="card-body">
            {{-- Pesan Sukses (jika ada dari redirect) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Tombol Tambah Data Barang --}}
            {{-- Menggunakan route() helper Laravel --}}
            <a href="{{route('barang.create')}}" class="btn btn-primary my-2">Tambah Data Barang</a>

            <div class="table-responsive">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID BARANG</th>
                            <th>NAMA BARANG</th>
                            <th>NAMA KATEGORI</th>
                            <th>NAMA SUPLIER</th>
                            <th>STOK</th>
                            <th>HARGA BELI</th>
                            <th>HARGA JUAL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menggunakan @forelse untuk mengulang data dari $barang --}}
                        {{-- $barang adalah variabel yang dikirim dari Controller --}}
                        @forelse($barang as $item)
                            <tr>
                                <td>{{ $item->id_barang }}</td> {{-- Sesuaikan dengan nama kolom ID di DB Anda --}}
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? 'N/A' }}</td> {{-- Akses relasi kategori --}}
                                <td>{{ $item->suplier->nama_suplier ?? 'N/A' }}</td> {{-- Akses relasi suplier --}}
                                <td>{{ $item->stok }}</td>
                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td> {{-- Ini harga jual --}}
                                <td>
                                    {{-- Tombol Ubah (Edit) --}}
                                    {{-- Menggunakan route() helper dan mengirim ID barang --}}
                                    <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-warning btn-sm"> Ubah </a>

                                    {{-- Tombol Hapus (Delete) - Menggunakan Form untuk DELETE Request --}}
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin Hapus Data {{ $item->nama_barang }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"> Hapus </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data barang yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- End table-responsive --}}
        </div>
    </div>
@endsection