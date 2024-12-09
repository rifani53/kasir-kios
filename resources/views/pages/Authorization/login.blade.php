<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <div class="container">
        @auth
            <p>Congrats, you are logged in!</p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <!-- Form Register -->
            <div class="form-container" id="register" style="display: block;">
                <h2>Register</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Register</button>
                    <p>Sudah punya akun? <a href="#" onclick="showLogin()">Login</a></p>
                </form>
            </div>

            <!-- Form Login -->
            <div class="form-container" id="login" style="display: none;">
                <h2>Login</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="text" name="loginname" placeholder="Name" required>
                    <input type="password" name="loginpassword" placeholder="Password" required>
                    <button type="submit">Login</button>
                    <p>Belum punya akun? <a href="#" onclick="showRegister()">Register</a></p>
                </form>
            </div>
        @endauth
    </div>

    <script>
        function showLogin() {
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }

        function showRegister() {
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').style.display = 'block';
        }
    </script>

</body>
</html>
