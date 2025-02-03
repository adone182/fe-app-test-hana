@extends('layouts.dashboard')

@section('css')
    <style>
        .user-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="email"], 
        input[type="text"], 
        input[type="password"], 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            color: #333;
        }

        input[type="email"]:focus, 
        input[type="text"]:focus, 
        input[type="password"]:focus, 
        select:focus {
            border-color: #5b9bd5;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        /* a {
            width: 100%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        a:hover {
            background-color: #d32f2f;
        } */

    </style>
@endsection

@section('content')
    <h1 style="text-align: center;">Tambah Pengguna</h1>
    
    <form class="user-form" id="addUserForm">
        @csrf
        <label class="label">Email</label>
        <input class="input" type="email" name="user_email" id="user_email" required>

        <label>Nama Lengkap</label>
        <input type="text" name="user_fullname" id="user_fullname" required>

        <label>Password</label>
        <input type="password" name="user_password" id="user_password" required>

        <label>No HP</label>
        <input type="text" name="user_nohp" id="user_nohp" required>

        <button type="submit" class="btn-primary">Simpan</button>
    </form>

    <script>
        const token = localStorage.getItem('auth_token');

        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = {
                user_email: document.getElementById('user_email').value,
                user_fullname: document.getElementById('user_fullname').value,
                user_password: document.getElementById('user_password').value,
                user_nohp: document.getElementById('user_nohp').value,
            };

            fetch('http://127.0.0.1:5000/api/users', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                window.location.href = '/users';
                alert('Pengguna berhasil ditambahkan!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menambahkan pengguna.');
            });
        });

    </script>
@endsection

