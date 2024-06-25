<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(7,7,92,1) 22%, rgba(0,212,255,1) 100%);
            padding: 20px;
        }
        .container {
            margin-top: 8% 
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ced4da;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="{{ route('manager.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" name="nama" id="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="kasir">Kasir</option>
                    <option value="dapur">Dapur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('manager.users.index') }}" class="btn btn-secondary item-center mt-2"><i class="fas fa-arrow-left"></i> Kembali</a>
            </form>
    </div>
</body>
</html>
