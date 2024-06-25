{{-- MENU UNTK MANAGER --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Restoran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            background-color: #cd0d80; /* Warna latar belakang */
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .menu-item {
            background-color: #ffffff; /* Warna latar belakang card */
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .menu-item img {
            max-width: 100px;
            max-height: 50px;
            display: block;
            margin: 0 auto;
        }
        .menu-details {
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-top: 10px;
        }
        button[type="button"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color:   #3b7941;
            color: black;
            cursor: pointer;
            margin-top: 10px;
        }
        button[type="button"]:hover {
            background-color: rgb(35, 238, 17);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 class="text-center text-light"> Daftar Menu</h1>
        <!-- Input untuk mencari makanan -->
        <div class="form-inline mb-3">
            <input class="form-control mr-sm-1 mb-1" type="search" placeholder="Cari Makanan dan Minuman" aria-label="Search" id="searchInput" style="width: 100%;">
            <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="button" onclick="searchFood()">Cari</button>
            
        </div>
        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
    </form>
    <!-- Daftar menu -->
    <div class="row" id="menuList">
        <!-- Loop melalui daftar menu di sini -->
        @foreach($menu as $item)
            <div class="col-md-4">
                <div class="menu-item">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                    <div class="menu-details">
                        <div>{{ $item->nama }}</div>
                        <div>Rp {{ $item->harga }}</div>
                        <!-- Tombol edit -->
                        <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                        <!-- Tombol hapus -->
                        <form id="deleteForm" action="{{ route('menu.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Menu akan dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                        </form>    
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function searchFood() {
            // Mendapatkan nilai input pencarian
            var searchText = document.getElementById('searchInput').value.toLowerCase();

            // Mendapatkan semua item makanan
            var foodItems = document.querySelectorAll('.menu-item');

            // Loop melalui setiap item makanan
            for (var i = 0; i < foodItems.length; i++) {
                var foodName = foodItems[i].querySelector('.menu-details div:first-child').textContent.toLowerCase();

                // Memeriksa apakah nama makanan cocok dengan pencarian
                if (foodName.indexOf(searchText) > -1) {
                    // Menampilkan item makanan jika cocok
                    foodItems[i].style.display = '';
                } else {
                    // Menyembunyikan item makanan jika tidak cocok
                    foodItems[i].style.display = 'none';
                }
            }       
        }
    </script>
    <script>
        document.getElementById("deleteForm").addEventListener("submit", function(event) {
            var confirmation = confirm("Apakah Anda yakin ingin menghapus item ini?");
            if (!confirmation) {
                event.preventDefault(); // Mencegah form untuk di-submit jika pengguna membatalkan
            }
        });
    </script>
</body>
</html>
