<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Meja Baru</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2dc970;
            padding: 20px;
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
        input[type="number"],
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
        .btn-back {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
            <div class="card-body">
                <form action="{{ route('manager.tables.store') }}" method="POST">
                    
                    @csrf
                    <div class="form-group">
                        <label for="table_number">Nomor Meja:</label>
                        <input type="number" class="form-control" id="table_number" name="qr_code" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Meja</button>
                        <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary btn-back mt-3"><i class="fas fa-arrow-left" ></i> Kembali</a>
                </form>
            </div>  
</body>
</html>
