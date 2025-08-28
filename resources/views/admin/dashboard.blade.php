<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            color: #333;
            display: flex;
        }

        .sidebar-area {
            min-height: 100vh;
            width: 20vw;
            border-right: 2px solid #2A5934;
            display: flex;
            flex-direction: column;

        }

        .logo-container {
            margin-top: 20px;
            margin-left: 20px;
            margin-right: 20px;
            width: calc(100%-40px);
            max-height: 120px;
        }

        .logo-container img {
            /* Apply properties directly to the image */
            width: 100%;
            height: 100%;
            /* Or a specific height if needed */
            object-fit: cover;
        }

        .main-menu {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 15%;
            flex-grow: 1;
            /* This pushes the profile-menu to the bottom */
            display: flex;
            flex-direction: column;

            gap: 15px;
        }


        .main-menu a {
            text-decoration: none;
            color: #333;
        }

        .main-menu .menu-option {
            font-weight: 600;
            padding: 5px;
            color: inherit;
            font-size: large;
        }

        .main-menu .menu-option:hover {
            text-decoration: underline;
        }

        .profile-menu {
            padding-bottom: 10px;
            padding-top: 10px;
            background-color: red;
            font-weight: 500;
            color: white;
            font-size: larger;
            text-align: center;
        }

        .profile-menu:hover {
            opacity: 60%;
        }

        .profile-menu .profile-name {
            margin-left: 5px;
            flex-grow: 1;
            font-weight: 500;

        }

        .profile-menu img {
            height: 50px;
            width: 50px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }

        .content-area {
            background-color: #f2f2f4;
            height: 100vh;
            width: 80vw;
            height: 100vh;
            padding: 3%;
            box-sizing: border-box;
            overflow-y: hidden;
        }

        .content-box {
            width: 100%;
            /* The box fills 100% of the padded parent area */
            height: 100%;
            /* Ensures it takes up at least the full height of the parent */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>


    <div class="sidebar-area">
        <div class="logo-container">
            <img src="{{ asset('images/logo.jpg') }}">
        </div>
        <div class="main-menu">
            <a href="{{ route('admin.bookings')}}">
                <div class="menu-option">
                    Booking
                </div>
            </a>
            <a href="{{ route('admin.orders')}}">
                <div class="menu-option">
                    Pesanan
                </div>
            </a>
            <a href="{{ route('admin.products')}}">
                <div class="menu-option">
                    Produk
                </div>
            </a>
            <a href="{{ route('admin.tourist.attractions')}}">
                <div class="menu-option">
                    Tempat Wisata
                </div>
            </a>
            <a href="{{ route('admin.accommodations')}}">
                <div class="menu-option">
                    Penginapan
                </div>
            </a>
        </div>
        <a href="#" title="click to logout" style="text-decoration: none;">
            <div class="profile-menu">
                <div>Logout</div>
            </div>
        </a>
    </div>
    <div class="content-area">
        <div class="content-box">
            @yield('content')
        </div>
    </div>
</body>

</html