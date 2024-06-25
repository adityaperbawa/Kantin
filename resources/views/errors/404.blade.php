{{-- views -> errors -> 404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unauthorized Access</title>
</head>
<body>
    <script>
        alert('HARAP LOGIN MENGGUNAKAN AKUN MANAGER !!');
        window.location = "{{ route('login') }}";
    </script>
</body>
</html>
