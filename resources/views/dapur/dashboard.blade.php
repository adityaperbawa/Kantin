<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dapur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/kd.css">
</head>
<body>
    <header>
    <h1 class="text-center">Halaman Dapur</h1>
<div class="position-absolute align-items-center mb-4">
    <button onclick="logout()" class="btn btn-danger logout-btn">Logout</button>
</div>
</header>
    <div class="container">
        @if(Auth::check() && Auth::user()->role == 'dapur')
            <p>Selamat datang, {{ Auth::user()->nama }}!</p>
        @endif
        @if($orders->isEmpty())
            <p>Tidak ada pesanan yang tersedia.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Item</th>
                        <th>Meja</th>
                        <th>Nama Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->menu->nama }}</td> <!-- Menampilkan nama item -->
                            <td>{{ $order->table->qr_code }}</td> <!-- Menampilkan nomor meja dari qr_code -->
                            <td>{{ $order->nama_pelanggan }}</td>
                            <td>
                                <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Apakah pesanan sudah selesai?');">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Selesaikan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    </script>
</body>
</html>
