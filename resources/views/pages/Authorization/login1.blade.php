<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            background-color: #f5f5f5; /* Light background for contrast */
            padding: 40px;
            text-align: center;
        }
        .left img {
            width: 200px;
            height: auto;
            border-radius: 50%; /* Circular image */
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
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .input-container {
            width: 100%;
            max-width: 400px; /* Batasi lebar input */
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
        .button-container {
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 400px; /* Maksimal lebar tombol */
        }
        .login-button {
            width: 100%;
            padding: 12px 20px;
            background-color: #0000FF;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .toggle-container {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }
        .toggle-container p {
            margin: 0;
            font-size: 14px;
            text-align: center;
        }
        .toggle-link {
            color: #5A4FCF;
            text-decoration: none;
            transition: color 0.3s;
        }
        .toggle-link:hover {
            color: #003d80; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <img alt="Illustration of a small shop" src="https://storage.googleapis.com/a1aa/image/fHANdL3sb619ZqOAyfRQYj0QKnX6vOhF6dIqQp77nyWr5xtTA.jpg"/>
            <h1>Kios Anis</h1>
        </div>
        <div class="right">
            @auth
                <h2>Welcome Back!</h2>
                <p>Congrats, you are logged in!</p>
                <form action="{{ route('logout') }}" method="POST" class="form-container">
                    @csrf
                    <div class="button-container">
                        <button type="submit" class="login-button">Logout</button>
                    </div>
                </form>
            @else
                <div class="form-container" id="login" style="display: block;"> <!-- Form Login -->
                    <h2>Login</h2>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="input-container">
                            <input type="text" name="loginname" placeholder="Name" required>
                        </div>
                        <div class="input-container">
                            <input type="password" name="loginpassword" placeholder="Password" required>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="login-button">Login</button>
                        </div>
                        <div class="toggle-container">
                            <p>Don't have an account? <a href="#" class="toggle-link" onclick="showRegister()">Register</a></p>
                        </div>
                    </form>
                </div>
                <div class="form-container" id="register" style="display: none;"> <!-- Form Register -->
                    <h2>Register</h2>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="input-container">
                            <input type="text" name="name" placeholder="Name" required>
                        </div>
                        <div class="input-container">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-container">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="login-button">Register</button>
                        </div>
                        <div class="toggle-container">
                            <p>Already have an account? <a href="#" class="toggle-link" onclick="showLogin()">Login</a></p>
                        </div>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login').style.display = 'none';
            document.getElementById('register').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }
    </script>
</body>
</html>
