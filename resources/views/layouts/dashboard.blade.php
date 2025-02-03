<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .sidebar ul li.active {
            background-color: #007bff;
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
            padding: 5px;
            border-radius: 5px;
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
            font-size: 16px;
            border: none;
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
            <img id="logo" style="padding: 15px; border-radius: 50%; text-align: center;" 
            src="https://dummyimage.com/100x100/000/fff&text=Logo" alt="logo">       

            <ul id="menuList">
            </ul>
            
            <li style="list-style: none">
                <form id="logoutForm" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            @yield('content')
        </div>
    </div>

    <script>

        document.getElementById('logoutForm').addEventListener('submit', function(event) {
            event.preventDefault();
        
            fetch('http://127.0.0.1:5000/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    window.location.href = '/login'; 
                    localStorage.removeItem('auth_token');
                } else {
                    alert('Logout failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                alert('There was an error logging out.');
            });
        });
           
        const fetchWithAuth = (url) => {
            const token = localStorage.getItem('auth_token');
            return fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
        };

        // Fetch menu
        fetchWithAuth('http://127.0.0.1:5000/api/menu')
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const menuList = document.getElementById('menuList');
                menuList.innerHTML = '';

                data.forEach(menuItem => {
                    const menuItemElement = document.createElement('li');
                    const menuUrl = `/${menuItem.route}`;

                    menuItemElement.innerHTML = `
                        <a href="${menuUrl}" id="${menuItem.route}Link">${menuItem.name}</a>
                    `;
                    menuList.appendChild(menuItemElement);
                });
            }
        })
        .catch(error => console.error('Error fetching menu data:', error));

        // Fetch logo
        fetchWithAuth('http://127.0.0.1:5000/api/theme/logo')
        .then(response => response.json())
        .then(data => {
            if (data.url) {
                document.getElementById('logo').src = data.url;
            }
        })
        .catch(error => console.error('Error fetching logo:', error));

        // Fetch background
        fetchWithAuth('http://127.0.0.1:5000/api/theme/background')
        .then(response => response.json())
        .then(data => {
            if (data.url) {
                document.querySelector('.main-content').style.backgroundImage = `url(${data.url})`;
                document.querySelector('.main-content').style.backgroundSize = 'cover';
                document.querySelector('.main-content').style.backgroundPosition = 'center';
                document.querySelector('.main-content').style.backgroundAttachment = 'fixed';
            }
        })
        .catch(error => console.error('Error fetching background:', error));

    </script>
</body>
</html>
