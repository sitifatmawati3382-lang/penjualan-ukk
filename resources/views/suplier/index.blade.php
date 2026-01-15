@extends('layout.layout')

@section('konten')
    <div class="card m-2">
        <div class="card-header">
            <h1>Data Suplier</h1>
        </div>
        <div class="card-body">
            {{-- Pesan Sukses (jika ada dari redirect) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <a href="{{ route('suplier.create') }}" class="btn btn-primary my-2">Tambah Data Suplier</a>

            <div class="table-responsive">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID SUPLIER</th>
                            <th>NAMA SUPLIER</th>
                            <th>NO. HP</th>
                            <th>ALAMAT</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suplier as $item)
                            <tr>
                                <td>{{ $item->id_suplier }}</td>
                                <td>{{ $item->nama_suplier }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    {{-- Tombol Ubah --}}
                                    <a href="{{ route('suplier.edit', $item->id_suplier) }}" class="btn btn-warning btn-sm">Ubah</a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('suplier.destroy', $item->id_suplier) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin Hapus Data {{ $item->nama_suplier }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data suplier yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
