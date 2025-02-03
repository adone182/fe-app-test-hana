<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Media query untuk responsif */
        @media (max-width: 600px) {
            .container {
                margin: 0 15px;
                padding: 15px;
            }
            input[type="email"], input[type="password"], .btn {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="user_email" id="user_email" value="{{ old('email') }}" required>
                <div id="emailError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="user_password" id="user_password" required>
                <div id="passwordError" class="error"></div>
            </div>
            <div id="loginError" class="error"></div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

            const email = document.getElementById('user_email').value;
            const password = document.getElementById('user_password').value;

            document.getElementById('emailError').innerText = '';
            document.getElementById('passwordError').innerText = '';
            document.getElementById('loginError').innerText = '';

            if (!email || !password) {
                if (!email) document.getElementById('emailError').innerText = 'Email tidak boleh kosong';
                if (!password) document.getElementById('passwordError').innerText = 'Password tidak boleh kosong';
                return;
            }

            fetch("http://127.0.0.1:5000/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_email: email,
                    user_password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    localStorage.setItem('auth_token', data.token);

                    window.location.href = "/dashboard";
                } else {
                    document.getElementById('loginError').innerText = data.message || 'Login gagal';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loginError').innerText = 'Terjadi kesalahan, coba lagi.';
            });
        });
    </script>
</body>
</html>
