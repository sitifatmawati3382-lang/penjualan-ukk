@extends('layout.layout')

@section('konten')
<div class="card m-2">
    <div class="card-header">
        <h1>Data Pelanggan</h1>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary my-2">Tambah Data Pelanggan</a>

        <div class="table-responsive">
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $item)
                        <tr>
                            <td>{{ $item->id_pelanggan }}</td>
                            <td>{{ $item->nama_pelanggan }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>
                                {{-- Tombol Ubah --}}
                                <a href="{{ route('pelanggan.edit', $item->id_pelanggan) }}" class="btn btn-warning btn-sm">Ubah</a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('pelanggan.destroy', $item->id_pelanggan) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin hapus {{ $item->nama }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
