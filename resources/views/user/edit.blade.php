@extends('layouts.dashboard')

@section('css')
    <style>
        /* Styling untuk form */
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* a {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            margin-top: 12px;
            text-decoration: none;
        }

        a:hover {
            background-color: #d32f2f;
        } */

    </style>
@endsection

@section('content')
    <h1 style="text-align: center;">Edit Pengguna</h1>

    <form class="user-form" id="editUserForm">
        @csrf
        @method('PUT')

        <label>Email</label>
        <input type="email" name="user_email" id="user_email" required>

        <label>Nama Lengkap</label>
        <input type="text" name="user_fullname" id="user_fullname" required>

        <label>Password <span style="color: red;font-size: 12px;">(Kosongkan jika tidak ingin mengubah)</span></label>
        <input type="password" name="user_password" id="user_password">

        <label>No HP</label>
        <input type="text" name="user_nohp" id="user_nohp">

        <label>Status</label>
        <select name="user_status" id="user_status">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <script>
        const token = localStorage.getItem('auth_token');

        document.addEventListener("DOMContentLoaded", async function () {
            const userId = new URLSearchParams(window.location.search).get('id');
            if (!userId) {
                alert("User ID tidak ditemukan.");
                window.location.href = "/users";
                return;
            }

            try {
                const response = await fetch(`http://127.0.0.1:5000/api/users/${userId}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": `Bearer ${token}`,
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || "Gagal mengambil data user.");
                }

                document.getElementById("user_email").value = result.data.user_email;
                document.getElementById("user_fullname").value = result.data.user_fullname;
                document.getElementById("user_nohp").value = result.data.user_nohp || "";
                document.getElementById("user_status").value = result.data.user_status;
            } catch (error) {
                console.error("Error fetching user:", error);
                alert("Terjadi kesalahan saat mengambil data pengguna.");
                window.location.href = "/users";
            }

            document.getElementById("editUserForm").addEventListener("submit", async function (event) {
                event.preventDefault();

                const formData = new FormData(this);
                const requestData = {
                    user_email: formData.get("user_email"),
                    user_fullname: formData.get("user_fullname"),
                    user_nohp: formData.get("user_nohp"),
                    user_status: formData.get("user_status"),
                };

                if (formData.get("user_password")) {
                    requestData.user_password = formData.get("user_password");
                }

                try {
                    const response = await fetch(`http://127.0.0.1:5000/api/users/${userId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": `Bearer ${token}`,
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify(requestData),
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || "Gagal mengupdate user.");
                    }

                    alert("User berhasil diperbarui!");
                    window.location.href = "/users";
                } catch (error) {
                    console.error("Error updating user:", error);
                    alert("Terjadi kesalahan saat mengupdate pengguna.");
                }
            });
        });
    </script>
@endsection
