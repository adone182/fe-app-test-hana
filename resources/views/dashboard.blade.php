@extends('layouts.dashboard')

@section('content')
    <h1>Dashboard</h1>
    <div class="stats">
        <div>
            <p>Total Pengguna</p>
            <h3 id="totalUsers">0</h3>
        </div>
        <div>
            <p>Pengguna Aktif</p>
            <h3 id="activeUsers">0</h3>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('auth_token');
        fetch('http://127.0.0.1:5000/api/dashboard/stats', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`, 
            }
        })
            .then(response => response.json())
            .then(data => {
                const totalUsers = data.data?.total_users ?? 0;
                const activeUsers = data.data?.active_users ?? 0;

                // Update DOM dengan data yang diterima
                document.getElementById('totalUsers').innerText = totalUsers;
                document.getElementById('activeUsers').innerText = activeUsers;
            })
            .catch(error => {
                console.error('Error fetching stats data:', error);
                
                document.getElementById('totalUsers').innerText = 0;
                document.getElementById('loggedInUsers').innerText = 0;
            });
    </script>
@endsection
