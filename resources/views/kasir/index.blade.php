@extends('layout.layout')

@section('konten')
<div class="row">
    <div class="col-md-5">
        <h2>Daftar Barang</h2>
        <div class="input-group mb-3">
            <input type="text" id="searchBarang" class="form-control" placeholder="Scan barcode atau ketik ID barang..." autofocus>
        </div>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="list-barang" style="height: 60vh; overflow-y: scroll;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                    <tr class="barang-item" data-id="{{ $item->id_barang }}" data-nama="{{ $item->nama_barang }}" data-harga="{{ $item->harga }}" data-harga-beli="{{ $item->harga_beli }}">
                        <td>{{ $item->id_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-7">
        <h2>Keranjang Belanja</h2>
        <form action="{{ route('kasir.store') }}" method="POST" id="form-transaksi">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label for="id_pelanggan">Nomor HP Pelanggan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="id_pelanggan" placeholder="Cari Pelanggan berdasarkan No. HP...">
                        <button class="btn btn-outline-secondary" type="button" id="btnCariPelanggan">Cari</button>
                    </div>
                    <small class="form-text text-muted" id="infoPelanggan">Pelanggan Umum</small>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="keranjang">
                    
                </tbody>
            </table>

            <div class="mt-4">
                <p>Total Harga: <span id="total-harga">Rp 0</span></p>
                <div class="form-group">
                    <label for="jumlah_bayar">Jumlah Bayar (Rp)</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kembalian">Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" readonly>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Bayar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchBarang = document.getElementById('searchBarang');
        const listBarang = document.querySelector('.list-barang tbody');
        const keranjangTable = document.getElementById('keranjang');
        const totalHargaEl = document.getElementById('total-harga');
        const formTransaksi = document.getElementById('form-transaksi');
        const jumlahBayarInput = document.getElementById('jumlah_bayar');
        const kembalianInput = document.getElementById('kembalian');

        const idPelangganInput = document.getElementById('id_pelanggan');
        const btnCariPelanggan = document.getElementById('btnCariPelanggan');
        const infoPelangganEl = document.getElementById('infoPelanggan');

        let keranjang = [];
        let idPelangganTerpilih = null;
        
        function renderKeranjang() {
            while (keranjangTable.firstChild) {
                keranjangTable.removeChild(keranjangTable.firstChild);
            }

            let totalHarga = 0;

            if (keranjang.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="5" class="text-center">Keranjang kosong.</td>';
                keranjangTable.appendChild(row);
            } else {
                keranjang.forEach(item => {
                    const subtotal = item.harga * item.jumlah;
                    totalHarga += subtotal;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.nama}</td>
                        <td>Rp ${formatRupiah(item.harga)}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm jumlah-barang" value="${item.jumlah}" min="1" data-id="${item.id}" style="width: 70px;">
                        </td>
                        <td>Rp ${formatRupiah(subtotal)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-from-cart" data-id="${item.id}">Hapus</button>
                        </td>
                    `;
                    keranjangTable.appendChild(row);
                });
            }

            totalHargaEl.textContent = `Rp ${formatRupiah(totalHarga)}`;
            updateHiddenInputs(totalHarga);
            hitungKembalian();
        }

        function updateHiddenInputs(totalHarga) {
            document.querySelectorAll('input[name^="keranjang"], input[name="total_bayar"], input[name="id_pelanggan"]').forEach(el => el.remove());

            keranjang.forEach((item, index) => {
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = `keranjang[${index}][id]`;
                inputId.value = item.id;
                formTransaksi.appendChild(inputId);

                const inputJumlah = document.createElement('input');
                inputJumlah.type = 'hidden';
                inputJumlah.name = `keranjang[${index}][jumlah]`;
                inputJumlah.value = item.jumlah;
                formTransaksi.appendChild(inputJumlah);
            });

            const inputTotal = document.createElement('input');
            inputTotal.type = 'hidden';
            inputTotal.name = 'total_bayar';
            inputTotal.value = totalHarga;
            formTransaksi.appendChild(inputTotal);

            const inputPelanggan = document.createElement('input');
            inputPelanggan.type = 'hidden';
            inputPelanggan.name = 'id_pelanggan';
            inputPelanggan.value = idPelangganTerpilih;
            formTransaksi.appendChild(inputPelanggan);
        }
        
        function formatRupiah(angka) {
            const formatter = new Intl.NumberFormat('id-ID');
            return formatter.format(angka);
        }

        function hitungKembalian() {
            const totalBayar = parseFloat(formTransaksi.querySelector('input[name="total_bayar"]')?.value) || 0;
            const jumlahBayar = parseFloat(jumlahBayarInput.value) || 0;
            const kembalian = jumlahBayar - totalBayar;
            kembalianInput.value = `Rp ${formatRupiah(kembalian)}`;
        }

        function cariPelanggan() {
            const noHp = idPelangganInput.value.trim();

            if (noHp === '') {
                idPelangganTerpilih = null;
                infoPelangganEl.textContent = 'Pelanggan Umum';
                return;
            }

            fetch(`/kasir/cari-pelanggan-hp/${noHp}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        idPelangganTerpilih = data.pelanggan.id_pelanggan;
                        infoPelangganEl.textContent = `Pelanggan: ${data.pelanggan.nama_pelanggan} (${data.pelanggan.no_hp})`;
                    } else {
                        idPelangganTerpilih = null;
                        infoPelangganEl.textContent = 'Pelanggan tidak ditemukan!';
                        alert('Pelanggan tidak ditemukan!');
                    }
                    updateHiddenInputs(keranjang.reduce((sum, item) => sum + item.harga * item.jumlah, 0));
                })
                .catch(error => {
                    console.error('Error:', error);
                    idPelangganTerpilih = null;
                    infoPelangganEl.textContent = 'Terjadi kesalahan saat mencari pelanggan.';
                    alert('Terjadi kesalahan saat mencari pelanggan.');
                });
        }

        searchBarang.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const barcode = searchBarang.value.trim();
                
                if (barcode === '') return;

                const barangRow = listBarang.querySelector(`.barang-item[data-id="${barcode}"]`);
                
                if (barangRow) {
                    const id = barangRow.dataset.id;
                    const nama = barangRow.dataset.nama;
                    const harga = parseInt(barangRow.dataset.harga);
                    const hargaBeli = parseInt(barangRow.dataset.hargaBeli);

                    const existingItem = keranjang.find(item => item.id === id);

                    if (existingItem) {
                        existingItem.jumlah++;
                    } else {
                        keranjang.push({ id, nama, harga, harga_beli: hargaBeli, jumlah: 1 });
                    }
                    
                    renderKeranjang();
                    searchBarang.value = '';
                } else {
                    alert('Barang tidak ditemukan!');
                    searchBarang.value = '';
                }
            }
        });
        
        keranjangTable.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-from-cart')) {
                const id = e.target.dataset.id;
                keranjang = keranjang.filter(item => item.id !== id);
                renderKeranjang();
            }
        });

        keranjangTable.addEventListener('input', function (e) {
            if (e.target.classList.contains('jumlah-barang')) {
                const id = e.target.dataset.id;
                const jumlah = parseInt(e.target.value);
                const item = keranjang.find(item => item.id === id);
                if (item && jumlah > 0) {
                    item.jumlah = jumlah;
                    renderKeranjang();
                } else if (jumlah <= 0) {
                    keranjang = keranjang.filter(item => item.id !== id);
                    renderKeranjang();
                }
            }
        });
        
        jumlahBayarInput.addEventListener('input', function() {
            hitungKembalian();
        });

        btnCariPelanggan.addEventListener('click', cariPelanggan);
        idPelangganInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                cariPelanggan();
            }
        });
    });
</script>
@endpush