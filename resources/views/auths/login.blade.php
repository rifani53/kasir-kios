<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kios Anis</title>
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #4671ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            border-radius: 20px;
            width: 90%;
            max-width: 800px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            padding: 40px;
            text-align: center;
        }
        .left img {
            width: 200px;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .left h1 {
            font-size: 26px;
            margin: 0;
            color: #333;
        }
        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }
        .right h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .input-container {
            margin-bottom: 20px;
        }
        .input-container input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s;
        }
        .input-container input:focus {
            border-color: #5A4FCF;
            outline: none;
        }
        .login-button {
            background-color: #0000FF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #0056b3;
        }
        .toggle-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #5A4FCF;
            text-decoration: none;
            transition: color 0.3s;
        }
        .toggle-link:hover {
            color: #003d80;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <img alt="Illustration of a small shop" src="https://storage.googleapis.com/a1aa/image/fHANdL3sb619ZqOAyfRQYj0QKnX6vOhF6dIqQp77nyWr5xtTA.jpg" />
            <h1>Kios Anis</h1>
        </div>
        <div class="right">
            @auth
                <h2>Welcome Back!</h2>
                <p>Congrats, you are logged in!</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="login-button">Logout</button>
                </form>
            @else
                <h2>Login</h2>
                <form action="{{ route('auths.login') }}" method="POST">
                    @csrf
                    <div class="input-container">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-container">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="login-button">Login</button>
                </form>
                    <p>Don't have an account? <a href="{{ route('auths.index') }}" class="toggle-link">Register</a></p>
                </form>
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            @endauth
        </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
