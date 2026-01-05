@extends('layout.layout')

@section('konten')
    <div class="card m-2">
        <div class="card-header">
            <h1>Data Kategori Barang</h1>
        </div>
        <div class="card-body">
            {{-- Pesan Sukses (jika ada dari redirect) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Tombol Tambah --}}
            <a href="{{ route('kategori.create') }}" class="btn btn-primary my-2">Tambah Data Kategori</a>

            <div class="table-responsive">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID KATEGORI</th>
                            <th>NAMA KATEGORI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $item)
                            <tr>
                                <td>{{ $item->id_kategori }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>
                                    {{-- Tombol Ubah --}}
                                    <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Ubah</a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin hapus {{ $item->nama_kategori }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data kategori yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
