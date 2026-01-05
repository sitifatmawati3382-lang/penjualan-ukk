@extends('layout/layout')

@section('konten')
<div class="card m-2">
    <div class="card-header">
        <h3>Form Ubah Data Kategori</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-3 my-2">
                    <label for="nama_kategori">NAMA KATEGORI</label>
                </div>
                <div class="col-9 my-2">
                    <input type="text" name="nama_kategori" id="nama_kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           class="form-control">
                </div>
                
                <div class="col-3"></div>
                <div class="col-9">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
