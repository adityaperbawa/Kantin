<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager</title>
    <link href="{{ asset('css/manager.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
</head>
<body>
    <div>
    <header>
        <h4>HALAMAN MANAGER</h4>
        @if(auth()->check())
            <p>Selamat datang, {{ auth()->user()->nama }}</p>
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="button" class="logout-btn" onclick="confirmLogout()"><i class="fas fa-door-open"></i>Logout</button>
        </form>
    </header>
</div>
<div>
    <div class="container mt-5">
        <div class="row ">
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-cherry" style="border-radius: 20px">
                <div class="card-statistic-3 p-4" >
                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                    <div class="mb-4">
                    </div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Menu</h5>
                    </div>
                    <ul class="menu-list">
                        <li><a href="{{ route('menu.create') }}">Tambahkan Menu Baru</a></li>
                        <li><a href="{{ route('menu.show') }}">Lihat Daftar Menu</a></li>
                    </ul> 
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-blue-dark" style="border-radius: 20px" >
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Users</h5>
                    </div>
                    <ul class="menu-list">
                        <li><a href="{{ route('manager.users.index') }}">Lihat Daftar Pengguna</a></li>
                    </ul>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-green-dark" style="border-radius: 20px">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-table"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Tables</h5>
                    </div>
                    <ul class="menu-list">
                        <li><a href="{{ route('manager.tables.create') }}">Tambahkan Meja Baru</a></li>
                        <li><a href="{{ route('manager.tables.index') }}">Lihat Daftar Meja</a></li>
                    </ul>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-orange-dark" style="border-radius: 20px">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Report</h5>
                    </div>
                    <ul class="menu-list">
                        <li><a href="{{ route('order.history') }}">Lihat Riwayat Pesanan</a></li>
                    </ul>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                document.getElementById('logout-form').submit();
            } else {
                // Do nothing or handle the cancellation
            }
        }
    </script>
</body>
</html>
