@extends('layout/layout')

@section('konten')
<div class="card m-2">
    <div class="card-header">
        <h3>Form Ubah Data Suplier</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('suplier.update', $suplier->id_suplier) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-3 my-2">
                    <label for="nama_suplier">NAMA SUPLIER</label>
                </div>
                <div class="col-9 my-2">
                    <input type="text" name="nama_suplier" id="nama_suplier"
                           value="{{ old('nama_suplier', $suplier->nama_suplier) }}"
                           class="form-control">
                </div>

                <div class="col-3">
                    <label for="no_hp">NO. HP</label>
                </div>
                <div class="col-9">
                    <input type="text" name="no_hp" id="no_hp"
                           value="{{ old('no_hp', $suplier->no_hp) }}"
                           class="form-control">
                </div>

                <div class="col-3 my-2">
                    <label for="alamat">ALAMAT</label>
                </div>
                <div class="col-9 my-2">
                    <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control">{{ old('alamat', $suplier->alamat) }}</textarea>
                </div>

                <div class="col-3"></div>
                <div class="col-9">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('suplier.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
