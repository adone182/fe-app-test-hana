<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        /* Layout utama */
        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            height: 100%;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #fff;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            text-align: start;
            border-bottom: 1px solid #444;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #007bff;
            color: white;
        }

        /* Konten utama */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
        }

        .main-content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats div {
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            width: 48%;
            text-align: center;
        }

        .stats div h3 {
            margin: 0;
            font-size: 30px;
        }

        /* Tombol logout */
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>

    @yield('css')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
               
                <li><a href="{{ route('dashboard') }}" id="dashboardLink">Dashboard</a></li>
                <li><a href="{{ route('users.index') }}" id="usersLink">Master Pengguna</a></li>
                <li><a href="{{ route('settings.index') }}" >Settings</a></li>
                <li>
                    <form >
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            @yield('content')
        </div>
    </div>
</body>
</html>
