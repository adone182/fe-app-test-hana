@extends('layouts.dashboard')

@section('content')
    <h1>Settings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ url('/settings') }}" method="POST">
        @csrf
        <div>
            <label for="background_image">Gambar Background:</label>
            <input type="text" name="background_image" id="background_image" placeholder="URL gambar background" value="{{ session('background_image') }}">
        </div>
        <div>
            <label for="logo">Logo Website:</label>
            <input type="text" name="logo" id="logo" placeholder="URL logo" value="{{ session('logo') }}">
        </div>
        <div>
            <label for="menu_items">Susunan Menu:</label>
            <textarea name="menu_items" id="menu_items" rows="5" placeholder="Susunan menu dalam format JSON">{{ session('menu_items') }}</textarea>
        </div>
        <button type="submit">Simpan Pengaturan</button>
    </form>
@endsection

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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
