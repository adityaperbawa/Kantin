<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <h2>Daftar Pengguna</h2>
    <!-- Form Cari -->
    <form class="form-inline mb-3 ml-5">
        <input class="form-control mr-sm-1 mt-3" type="search" placeholder="Cari Pengguna" aria-label="Search" id="searchInput" style="width: 20%; margin-left:550px;">
        <button class="btn btn-success mt-3" type="button" onclick="searchUsers()">Cari</button>
        </form>
        </header> 
        <div class="container">
        <div class="text-center mt-3 ml-4">
            <a href="{{ route('manager.dashboard') }}" class="btn btn-warning"><i class="fas fa-home"></i></a>  
            <a href="{{ route('manager.users.create') }}" class="btn btn-warning"><i class="fas fa-user-plus"></i></a>
        </div>
        <!-- Daftar Pengguna -->
        <div class="row" id="userList">
            @foreach($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card" style="background-color: rgba(240, 248, 255, 0.5); border-radius:10%;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->nama }}</h5>
                        <p class="card-text">Email: {{ $user->email }}</p>
                        <p class="card-text">Role: {{ $user->role }}</p>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('manager.users.edit', $user->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i> Edit</a>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('manager.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="confirmDeletion({{ $user->id }})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>                           
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function searchUsers() {
            var input, filter, cards, card, name, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cards = document.getElementById("userList").getElementsByClassName("card");
            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                name = card.querySelector(".card-title");
                txtValue = name.textContent || name.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>
    <script>
        function confirmDeletion(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
    </script>
</body>
</html>
