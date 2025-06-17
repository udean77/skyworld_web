<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkyWorld')</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40jHzjPzCSs5lPtxeBTnQryoPjL/ApmkPxKkXl+FtJ/L/dD9ZJ8S+q0B/QvN/FzK/x0fP0fQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            color: #fff;
            background-image: url('https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-attachment: fixed;
        }

        .navbar {
            background: rgba(20, 30, 60, 0.92);
            padding: 0 40px;
            display: flex;
            align-items: center;
            height: 70px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.18);
        }

        .navbar .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00eaff;
            letter-spacing: 2px;
            margin-right: 20px;
            text-shadow: 0 2px 8px #00eaff44;
        }

        .navbar .brand {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin-right: 40px;
            text-shadow: 0 2px 8px #fff2;
        }

        .navbar .nav {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .navbar .nav a {
            color: #b2e0ff;
            text-decoration: none;
            margin: 0 18px;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .navbar .nav a.active,
        .navbar .nav a:hover {
            color: #ffe066;
        }

        .main-title {
            color: #ffe066;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 40px 0 30px 60px;
            text-shadow: 0 2px 12px #00eaff44;
        }

        .ticket-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ticket-card {
            background: rgba(20, 30, 60, 0.92);
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.18);
            display: flex;
            align-items: center;
            padding: 32px;
            min-height: 220px;
            position: relative;
            padding-bottom: 80px;
        }

        .ticket-card img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 16px;
            margin-right: 32px;
            box-shadow: 0 2px 12px #00eaff44;
        }

        .ticket-card .info {
            flex: 1;
        }

        .ticket-card .info h3 {
            margin: 0 0 10px 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffe066;
            text-shadow: 0 2px 8px #00eaff44;
        }

        .ticket-card .btn-buy {
            position: absolute;
            bottom: 24px;
            right: 24px;
            background: linear-gradient(90deg, #ffe066 0%, #00eaff 100%);
            color: #222;
            border: none;
            border-radius: 24px;
            padding: 12px 32px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 2px 8px #00eaff44;
            transition: background 0.2s;
        }

        .ticket-card .btn-buy:hover {
            background: linear-gradient(90deg, #00eaff 0%, #ffe066 100%);
        }

        .ticket-card.purple {
            background: linear-gradient(135deg, #3a1c71 0%, #d76d77 50%, #ffe066 100%);
            color: #fff;
        }

        .ticket-card.purple .info h3,
        .ticket-card.purple .info p {
            color: #fff;
        }

        .ticket-card.purple .btn-buy {
            background: #ffe066;
            color: #222;
        }

        @media (max-width: 900px) {
            .ticket-grid {
                grid-template-columns: 1fr;
            }
            .main-title {
                margin-left: 20px;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                height: auto;
                padding: 10px;
            }
            .main-title {
                font-size: 1.5rem;
                margin: 20px 0 20px 10px;
            }
            .ticket-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 18px;
            }
            .ticket-card img {
                margin: 0 0 18px 0;
                width: 100%;
                height: 120px;
            }
        }
    </style>
    @yield('head')
</head>
<body>
    <div class="navbar">
        <span class="logo">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="20" fill="#00eaff"/>
                <circle cx="20" cy="20" r="12" fill="#203a43"/>
                <circle cx="28" cy="12" r="3" fill="#ffe066"/>
                <circle cx="12" cy="28" r="2" fill="#fff"/>
            </svg>
        </span>
        <span class="brand">SKYWORLD</span>
        <div class="nav">
            <a href="/beranda" class="active">Beranda</a>

            @if(session('customer_id'))
                <a href="{{ url('/customer/' . session('customer_id') . '/riwayat') }}">Riwayat Pesan</a>
                <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link" style="color: #b2e0ff; text-decoration: none;">Logout</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}">Masuk</a>
            @endif
        </div>
    </div>

    @yield('content')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5g6aC3" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>
