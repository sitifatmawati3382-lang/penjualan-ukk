@extends('layout/layout')
@section('konten')
    <div class="card m-2">
        <div class="card-header">
            <h3>Form Ubah Data Barang</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.update', $barang->id_barang) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-3">
                        <label for="id_barang">ID BARANG</label>
                    </div>
                    <div class="col-9">
                        <input type="text" name="id_barang" id="id_barang" class="form-control" value="{{ $barang->id_barang }}" readonly>
                    </div>
                    <div class="col-3 my-2">
                        <label for="nama_barang">NAMA BARANG</label>
                    </div>
                    <div class="col-9 my-2">
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $barang->nama_barang }}">
                    </div>
                    <div class="col-3">
                        <label for="id_kategori">NAMA KATEGORI</label>
                    </div>
                    <div class="col-9">
                        <select name="id_kategori" id="id_kategori" class="form-select">
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori }}" @selected($item->id_kategori == $barang->id_kategori)>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-3">
                        <label for="id_suplier">NAMA SUPLIER</label>
                    </div>
                    <div class="col-9 my-2">
                        <select name="id_suplier" id="id_suplier" class="form-select">
                            @foreach ($suplier as $item)
                                <option value="{{ $item->id_suplier }}" @selected($item->id_suplier == $barang->id_suplier)>
                                    {{ $item->nama_suplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="stok">STOK</label>
                    </div>
                    <div class="col-9">
                        <input type="text" name="stok" id="stok" class="form-control" value="{{ $barang->stok }}">
                    </div>
                    <div class="col-3 my-2">
                        <label for="harga_beli">HARGA BELI</label>
                    </div>
                    <div class="col-9 my-2">
                        <input type="text" name="harga_beli" id="harga_beli" class="form-control" value="{{ $barang->harga_beli }}">
                    </div>
                    <div class="col-3 my-2">
                        <label for="harga">HARGA</label>
                    </div>
                    <div class="col-9 my-2">
                        <input type="text" name="harga" id="harga" class="form-control" value="{{ $barang->harga }}">
                    </div>
                    <div class="col-3"></div>
                    <div class="col-9">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
