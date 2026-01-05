<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard E-Penjualan</title> 
        <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
        <style>
            /* Efek hover untuk nav-link di sidebar sekunder */
            .col-3.bg-secondary .nav-link {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .col-3.bg-secondary .nav-link:hover {
                background-color: rgba(255, 255, 255, 0.2);
                color: #fff;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row"> 
                <div class="col bg-primary text-white py-3"> 
                    <h1>E-Penjualan</h1>
                </div>
            </div>
            <div class="row"> <div class="col-3 bg-secondary text-white min-vh-100"> <h3 class="mt-2">Daftar Menu</h3>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link text-white">Dashboard</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}" class="nav-link text-white">Data Barang</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('suplier.index')}}" class="nav-link text-white">Data Suplier</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pelanggan.index')}}" class="nav-link text-white">Data Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('kategori.index')}}" class="nav-link text-white">Data Kategori Barang</a>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <a href="{{ route('kasir.index') }}" class="nav-link text-white">Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('laporan.harian')}}" class="nav-link text-white">Laporan Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white">Profile</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link text-white">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-9 bg-light min-vh-100"> 
                    @yield('konten')
                </div>
            </div>
            <div class="row"> <div class="col bg-dark text-white py-3 text-center"> <h3>&copy; 2025</h3>
                </div>
            </div>
        </div>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        @stack('scripts')
    </body>
</html>