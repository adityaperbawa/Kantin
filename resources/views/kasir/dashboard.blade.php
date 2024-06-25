<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kasir</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/kd.css') }}"> <!-- Sesuaikan dengan path CSS Anda -->
</head>
<body>
    <header>
        <div class="container">
            <h1 class="text-center">Halaman Kasir</h1>
            <div class="position-absolute align-items-center mb-4">
                <button onclick="logout()" class="btn btn-danger logout-btn">Logout</button>
            </div>
        </div>
    </header>

    <div class="container">
        @if(Auth::check() && Auth::user()->role == 'kasir')
            <p>Selamat datang, {{ Auth::user()->nama }}!</p>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($orders->isEmpty())
            <p>Tidak ada pesanan yang tersedia.</p>
        @else
            <!-- Form untuk bayar pesanan -->
            <form action="{{ route('orders.payMultiple') }}" method="POST">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Harga</th>
                            <th>Nama Pelanggan</th>
                            <th>Metode Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->menu->nama }}</td>
                                <td>Rp {{ number_format($order->menu->harga, 2) }}</td>
                                <td>{{ $order->nama_pelanggan }}</td>
                                <td>{{ $order->metode_pembayaran }}</td>
                                <td>
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success">Bayar Pesanan Terpilih</button>
            </form>
        @endif

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logout-form').submit();
                alert('Anda telah logout.');
            }
        }

        // Hapus notifikasi setelah ditutup
        $('.alert').alert();

        // Tambahkan fungsi untuk menutup alert
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);

        // Fungsi untuk menampilkan alert pesanan telah dikirim ke dapur
        function notifyDapur() {
            alert('Pesanan telah dikirim ke dapur.');
        }
    </script>
</body>
</html>
