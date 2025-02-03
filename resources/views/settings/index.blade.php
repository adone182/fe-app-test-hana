@extends('layouts.dashboard')

@section('css')
    <style>
        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .alert {
            background-color: #28a745;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .file-input {
            display: block;
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
            font-size: 16px;
            transition: border-color 0.3s ease-in-out;
        }

        .file-input:hover {
            border-color: #007bff;
        }

        .file-input:focus {
            border-color: #0056b3;
            outline: none;
        }

        .file-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .file-container {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:focus {
            outline: none;
        }
    </style>
@endsection

@section('content')
    <h1>Settings</h1>

    <!-- Form untuk Background Image -->
    <form id="settingsForm1" method="POST" enctype="multipart/form-data" style="margin-bottom: 15px;">
        @csrf
        <div>
            <label for="background_image" class="file-label">Gambar Background:</label>
            <input type="file" name="background_image" id="background_image" accept="image/*" class="file-input">
        </div>
        <button type="submit">Simpan Pengaturan</button>
    </form>

    <!-- Form untuk Logo -->
    <form id="settingsForm2" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="logo" class="file-label">Logo Website:</label>
            <input type="file" name="logo" id="logo" accept="image/*" class="file-input">
        </div>
        <button type="submit">Simpan Pengaturan</button>
    </form>

    <script>
        const token = localStorage.getItem('auth_token');
    
        document.getElementById('settingsForm1').addEventListener('submit', function(event) {
            event.preventDefault();
    
            let formData = new FormData();
            let backgroundImage = document.getElementById('background_image').files[0];
            if (!backgroundImage) {
                alert('Please select a background image.');
                return;
            }
    
            formData.append('background_image', backgroundImage);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
            fetch('http://127.0.0.1:5000/api/theme/background', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Background image updated successfully!');
                } else {
                    alert('Failed to update background image: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error updating the background image.');
            });
        });

        document.getElementById('settingsForm2').addEventListener('submit', function(event) {
            event.preventDefault();
    
            let formData = new FormData();
            let logos = document.getElementById('logo').files[0];
            if (!logos) {
                alert('Please select a logo.');
                return;
            }
    
            formData.append('logo', logos);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
            fetch('http://127.0.0.1:5000/api/theme/logo', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Logo updated successfully!');
                } else {
                    alert('Failed to update logo: ' + (data.message || 'Unknown error.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error updating the background image.');
            });
        });
    
        // document.getElementById('settingsForm2').addEventListener('submit', function(event) {
        // event.preventDefault();

        //     let logoInput = document.getElementById('logo');
        //     if (!logoInput) {
        //         console.error('Element with ID "logo" not found!');
        //         alert('Logo input element not found!');
        //         return;
        //     }

        //     if (!logoInput.files || logoInput.files.length === 0) {
        //         alert('Please select a logo file.');
        //         return;
        //     }

        //     let formData = new FormData();
        //     formData.append('logo', logoInput.files[0]);
        //     formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        //     fetch('http://127.0.0.1:5000/api/theme/logo', {
        //         method: 'POST',
        //         headers: {
        //             'Authorization': `Bearer ${token}`,
        //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //         },
        //         body: formData
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.success) {
        //             alert('Logo updated successfully!');
        //         } else {
        //             alert('Failed to update logo: ' + (data.message || 'Unknown error.'));
        //         }
        //     })
        //     .catch(error => {
        //         console.error('Error:', error);
        //         alert('There was an error updating the logo.');
        //     });
        // });


    </script>
    

@endsection

