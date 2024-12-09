<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        @auth
        <p>congrats login</p>
        <form action ="/logout" method="POST"
        @csrf
        button  type="submit">logout</button>
        </form>



        <!-- Form Register -->
        <div class="form-container" id="register">
            <h2>Register</h2>
            <form action="/register" method="POST">
                <input type="text" name="name" placeholder="name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="password" required>
                <button type="submit">Register</button>
                <p>Sudah punya akun? <a href="#" onclick="showLogin()">Login</a></p>
            </form>
        </div>

        <!-- Form Login -->
        <div class="form-container" id="login" style="display: none;">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <input type="text" name="loginname" placeholder="name" required>
                <input type="password" name="loginpassword" placeholder="password" required>
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
