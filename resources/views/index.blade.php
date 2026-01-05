@extends('layout.layout')
@section('konten')
    <h1 class="text-center mb-3">Selamat Datang di E-Penjualan</h1>
    <div class="row">
        <div class="col-3">
            <div class="card p-2">
                <div class="card-header">
                    Jumlah Barang
                </div>
                <div class="card-body">
                    <h1>3 item</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-info p-2">
                <div class="card-header">
                Jumlah Suplier
            </div>
               <div class="card-body">
                    <h1>3 item</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-success p-2">
                <div class="card-header">
                Jumlah Kategori
            </div>
             <div class="card-body">
                    <h1>3 item</h1>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-warning p-2">
                <div class="card-header">
                Jumlah Transaksi Hari ini
            </div>
            <div class="card-body">
                    <h1>0 item</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
