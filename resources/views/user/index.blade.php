@extends('layouts.dashboard')

@section('css')
<style>
    /* Table Styling */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: #fff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .user-table th, .user-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .user-table th {
        background: #007bff;
        color: white;
    }

    .user-table tbody tr:hover {
        background: #f1f1f1;
    }

    /* Avatar */
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    /* Button Styling */
    .btn-primary {
        background: #174bdb;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: #218838;
    }

    .btn-edit {
        background: #ffc107;
        color: black;
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        margin-right: 5px;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .active-status {
        color: green;
        font-weight: bold;
    }

    .inactive-status {
        color: gray;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
    <h1 style="text-align: center; margin-bottom: 20px;">Master Pengguna</h1>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <button onclick="tambahPengguna()" class="btn-primary">Tambah Pengguna</button>
    </div>

    <table class="user-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="userList">
            <tr>
                <td colspan="4" style="text-align: center;">Loading...</td>
            </tr>
        </tbody>
    </table>

    <script>
        const token = localStorage.getItem('auth_token');
        document.addEventListener("DOMContentLoaded", function () {
            fetchUserList();
        });
    
        function fetchUserList() {
            fetch('http://127.0.0.1:5000/api/users', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(responseData => {
                const users = responseData.data;
                let userList = document.getElementById('userList');
                userList.innerHTML = "";
    
                users.forEach((user, index) => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${user.user_fullname}</td>
                        <td>${user.user_email}</td>
                        <td class="${user.user_status == 1 ? 'active-status' : 'inactive-status'}">
                            ${user.user_status == 1 ? "Active" : "Inactive"}
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editUser(${user.user_id})">Edit</button>
                            <button class="btn-delete" onclick="deleteUser(${user.user_id})">Hapus</button>
                        </td>
                    `;
                    userList.appendChild(row);
                });
            })
            .catch(error => {
                document.getElementById('userList').innerHTML = ` 
                    <tr><td colspan="5" style="text-align: center;">Gagal mengambil data pengguna.</td></tr>
                `;
                console.error("Error fetching users:", error);
            });
        }
    
        function tambahPengguna() {
            window.location.href = "{{ route('users.add') }}";
        }
    
        function editUser(userId) {
            window.location.href = `/users/${userId}/edit`;
        }
    
        function deleteUser(userId) {
            if (confirm(`Apakah Anda yakin ingin menghapus pengguna dengan ID: ${userId}?`)) {
                fetch(`http://127.0.0.1:5000/api/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'User deleted successfully!') {
                        document.getElementById(`user-row-${userId}`)?.remove();
                        alert(`Pengguna dengan ID ${userId} telah dihapus.`);
                    } else {
                        alert('Gagal menghapus pengguna. Coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus pengguna.');
                });
            }
        }
    
    </script>
    
@endsection
