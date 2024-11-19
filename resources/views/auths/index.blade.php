<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            width: 350px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card h4 {
            font-weight: lighter;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .text-center a {
            color: #17a2b8;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>Kios Anis</h4>
        </div>
        <form method="POST" action="{{ route('auths.register') }}">
            @csrf
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Nama:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ketikkan nama anda" required>
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="ketikkan email anda" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-key"></i> Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="ketikkan password anda" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation"><i class="fas fa-key"></i> Konfirmasi Password:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="konfirmasi password anda" required>
            </div>
            <button type="submit" class="btn btn-success btn-block mb-2">Daftar</button>
            <div class="text-center mt-2">
                <a href="{{ route('auths.login') }}" class="text-decoration-none"><i class="fas fa-sign-in-alt"></i> Sudah punya akun? Masuk di sini</a>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
