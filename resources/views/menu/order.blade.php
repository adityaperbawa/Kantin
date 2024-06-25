<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.menu-item {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    height: 200px;
}

.menu-item img {
    max-width: 100%;
    max-height: 50px;
    object-fit: cover;
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
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    margin-top: 10px;
}

button[type="button"]:hover {
    background-color: #0056b3;
}

.order-list-container {
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    overflow: hidden;
    width: 100%; 
}

.order-list-header {
    background-color: #f8f9fa;
    padding: 8px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-list-header:hover {
    background-color: #e9ecef;
}

.toggle-icon {
    font-size: 1.3rem;
    font-weight: bold;
}

.order-list {
    display: none;
    padding: 8px;
}

.order-list.active {
    display: block;
}

#orderList {
    list-style: none;
    padding: 0;
    margin-top: 5px;
}

#orderList li {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

#orderList li button {
    margin-left: 8px;
    font-size: 14px;
}

#totalPrice {
    font-weight: bold;
}

/* Responsive styles */
@media (max-width: 768px) {
    .menu-item {
        padding: 10px;
        height: auto;
    }
    .menu-item img {
        max-height: 150px;
    }
    .menu-details {
        margin-top: 10px;
    }
    input[type="text"] {
        margin-bottom: 10px;
    }
    .order-list-container {
        width: 100%; /* Lebar penuh untuk mobile */
    }
}


    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center" style="margin-bottom: -10px">Menu</h1>
        <!-- Formulir untuk memesan -->
        <form action="{{ route('order.store') }}" method="post" id="orderForm">
            @csrf
            <!-- Input untuk nama pelanggan -->
            <div class="form-group">
                <label for="nama_pelanggan"></label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
            </div>
            <!-- Input untuk mencari makanan -->
            <div class="form-inline mb-3">
                <input class="form-control mr-sm-1" type="search" placeholder="Cari Makanan" aria-label="Search" id="searchInput" style="width: 100%;">
                <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="button" onclick="searchFood()">Cari</button>
            </div>  
       
    <!-- Daftar pesanan dengan icon untuk membuka/tutup -->
    <div class="order-list-container mb-3">
        <div class="order-list-header" onclick="toggleOrderList()">
            <h5 style="margin-bottom: 5px;">Daftar Pesanan</h5>
            <span id="toggleIcon" class="toggle-icon">+</span>
        </div>
        <div class="order-list" id="orderListContainer">
            <ul id="orderList"></ul>
            <div style="font-size: 14px;">Total: Rp <span id="totalPrice">0</span></div>
            <!-- Input tersembunyi untuk menyimpan ID menu yang dipilih -->
            <input type="hidden" id="menu_ids" name="menu_ids">
            <!-- Input tersembunyi untuk metode pembayaran -->
            <input type="hidden" name="metode_pembayaran" value="Tunai">
            <!-- Tombol pesan -->
            <button type="submit" id="submitOrderBtn" class="btn btn-primary btn-sm btn-block mt-2" style="display: none;">Pesan</button>
        </div>
    </div>
    
            <!-- Input tersembunyi untuk menyimpan QR Code meja -->
            <input type="hidden" name="table_qr_code" value="{{ $table }}">
            <!-- Daftar menu -->
            <div class="row" id="menuList">
                @forelse($menu as $item)
                    <div class="col-md-4">
                        <div class="menu-item">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}">
                            <div class="menu-details">
                                <div>{{ $item->nama }}</div>
                                <div>Rp {{ number_format($item->harga, 2) }}</div>
                                @if ($item->stok > 0)
                                    <!-- Tombol tambahkan ke daftar pesanan -->
                                    <button type="button" onclick="addToOrder('{{ $item->nama }}', '{{ $item->id }}', '{{ $item->harga }}')">Tambah ke Pesanan</button>
                                @else
                                    <!-- Tombol tidak tersedia jika stok habis -->
                                    <button type="button" disabled>Tidak Tersedia</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 text-center">
                        <p class="text-muted">No results found for "{{ request('search') }}"</p>
                    </div>
                @endforelse
            </div>
    </div>
         
    <!-- Script untuk menampilkan pesan sukses -->
    @if (session('success'))
        <script>
            alert("Pesanan Anda telah berhasil diterima. Silakan lanjutkan pembayaran di kasir.");
        </script>
    @endif

    <script>
        var orderItems = [];
        var totalPrice = 0;

        function addToOrder(menuName, menuId, menuPrice) {
            // Tambahkan item ke daftar pesanan
            orderItems.push({ id: menuId, name: menuName, price: menuPrice });
            totalPrice += parseFloat(menuPrice);

            // Perbarui tampilan daftar pesanan dan total harga
            updateOrderList();
            updateTotalPrice();

            // Setel ID menu ke input tersembunyi
            document.getElementById('menu_ids').value = orderItems.map(item => item.id).join(',');

            // Tampilkan tombol pesan
            document.querySelector('button[type="submit"]').style.display = 'block';
        }

        function updateOrderList() {
            var orderList = document.getElementById('orderList');
            orderList.innerHTML = '';

            orderItems.forEach(function(item) {
                var listItem = document.createElement('li');
                listItem.textContent = item.name + ' - Rp ' + item.price;
                
                // Tombol hapus
                var deleteButton = document.createElement('button');
                deleteButton.textContent = 'Hapus';
                deleteButton.className = 'btn btn-sm btn-danger';
                deleteButton.style.marginLeft = '10px';
                deleteButton.onclick = function() {
                    removeOrderItem(item.id);
                };

                listItem.appendChild(deleteButton);
                orderList.appendChild(listItem);
            });
        }

        function updateTotalPrice() {
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        }

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

        function removeOrderItem(menuId) {
            // Temukan indeks item yang akan dihapus
            var index = orderItems.findIndex(item => item.id === menuId);

            if (index !== -1) {
                // Kurangi total harga
                totalPrice -= parseFloat(orderItems[index].price);

                // Hapus item dari daftar pesanan
                orderItems.splice(index, 1);

                // Perbarui tampilan daftar pesanan dan total harga
                updateOrderList();
                updateTotalPrice();

                // Setel kembali ID menu ke input tersembunyi
                document.getElementById('menu_ids').value = orderItems.map(item => item.id).join(',');

                // Sembunyikan tombol pesan jika tidak ada pesanan
                if (orderItems.length === 0) {
                    document.querySelector('button[type="submit"]').style.display = 'none';
                }
            }
        }

        function toggleOrderList() {
      var orderListContainer = document.getElementById('orderListContainer');
      var toggleIcon = document.getElementById('toggleIcon');

     if (orderListContainer.classList.contains('active')) {
        // Jika daftar pesanan sudah terbuka, tutup daftar pesanan
        orderListContainer.classList.remove('active');
        toggleIcon.textContent = '+';
     } else {
        // Jika daftar pesanan belum terbuka, buka daftar pesanan
        orderListContainer.classList.add('active');
         toggleIcon.textContent = '-';
      }
      }

    </script>
</body>
</html>
