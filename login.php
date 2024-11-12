<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Foodwise</title>
    <style>
        /* CSS Styles */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            overflow: hidden;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .side {
            width: 50%;
            padding: 40px;
            transition: transform 0.5s ease-in-out;
        }
        .bg-teal {
            background-color: #38b2ac;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .bg-white {
            background-color: white;
            color: #4a4a4a;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hidden { display: none; }
        .title { font-size: 24px; font-weight: bold; }
        .subtitle { margin-bottom: 20px; }
        .input-field { margin-bottom: 20px; }
        .input-field label { display: block; margin-bottom: 5px; }
        .input-field input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #38b2ac;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover { background-color: #319795; }
        .text-link {
            color: #38b2ac;
            cursor: pointer;
            text-decoration: underline;
        }
        .text-link:hover { color: #319795; }
    </style>
</head>
<body>

<?php $isLogin = true; // Set to true for login form, false for signup form ?>

<section class="container">
    <!-- Left Side - Image and Text -->
    <div class="side bg-teal">
        <h1 class="title">WeCare</h1>
        <p class="subtitle">
            Mari, untuk hidup sehat<br>
            Solusi Hidup Sehat <br>
            Dengan Diagnosis lebih awal <br>
        </p>
    </div>

    <!-- Right Side - Form (Login/Sign Up) -->
    <div class="side bg-white" id="formContainer">
        <?php if ($isLogin): ?>
            <!-- Login Form -->
            <h2 class="title">Selamat Datang!</h2>
            <p class="subtitle">Solusi Hidup Sehat</p>
            <form action="home.php" method="POST">
                <div class="input-field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username">
                </div>
                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password">
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p>Don't have an account? <span class="text-link" onclick="toggleForm()">Sign up for free</span></p>

        <?php else: ?>
            <!-- Signup Form -->
            <h2 class="title">Buat Akun Baru!</h2>
            <p class="subtitle">Bergabunglah bersama kami</p>
            <form action="signup.php" method="POST">
                <div class="input-field">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Nama Pengguna">
                </div>
                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email">
                </div>
                <div class="input-field">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi">
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <p>Already have an account? <span class="text-link" onclick="toggleForm()">Login here</span></p>
        <?php endif; ?>
    </div>

    </section>
<script>

function loginRedirect() {
        const loginForm = document.querySelector('form[action="home.php"]');
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            window.location.href = 'home.php';
        });
    }
    // Toggle between Login and Sign Up forms
    function toggleForm() {
        const formContainer = document.getElementById('formContainer');
        <?php $isLogin = !$isLogin; ?> // Toggle PHP variable
        formContainer.classList.toggle('hidden');
        window.location.reload(); // Reload to apply the form toggle
    }
    loginRedirect();
</script>

</body>
</html>

