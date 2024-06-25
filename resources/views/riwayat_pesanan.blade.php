<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2ac4a;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            border-radius: 10px;
            background-color: #fff;
        }
        .logout-btn {
            background-color: black;
            color: #fff;
            border: none;
        }
        .home-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            position: relative;
        }
        .btn-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-group" role="group">
            <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary mt-2"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        <h1 class="my-4">Riwayat Pesanan</h1>

        <!-- Formulir pencarian -->
        <form action="{{ route('orders.search') }}" method="GET" class="mb-4">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="tanggalMulai">Tanggal Mulai</label>
                    <input type="date" class="form-control mb-2" id="tanggalMulai" name="tanggalMulai" placeholder="Tanggal Mulai">
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="tanggalSelesai">Tanggal Selesai</label>
                    <input type="date" class="form-control mb-2" id="tanggalSelesai" name="tanggalSelesai" placeholder="Tanggal Selesai">
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="namaPelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control mb-2" id="namaPelanggan" name="namaPelanggan" placeholder="Nama Pelanggan">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Cari</button>
                </div>
            </div>
        </form>

        <!-- Tabel riwayat pesanan -->
        @if($completedOrders->isEmpty())
            <p>Tidak ada pesanan yang sudah selesai.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedOrders as $order)
                        <tr>
                            <td>{{ $order->nama_pelanggan }}</td>
                            <td>{{ $order->menu->nama }}</td>
                            <td>Rp {{ number_format($order->harga, 2) }}</td>
                            <td>{{ $order->metode_pembayaran }}</td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
