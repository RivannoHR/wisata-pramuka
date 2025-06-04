<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pulau Pramuka Travel')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Light gray background for the main content area */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensure body takes full viewport height */
        }

        /* Header Styles */
        header {
            background-color: #fff; /* White background for the header */
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Subtle shadow for depth */
        }
        .header-container {
            max-width: 1200px; /* Adjust as per your Figma's main content width */
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }
        .header-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px; /* Space between nav items */
        }
        .header-nav ul li a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 0;
            transition: color 0.3s ease;
        }
        .header-nav ul li a:hover {
            color: #007bff; /* Example hover color, adjust as needed */
        }
        .header-auth-button {
            background-color: #333; /* Dark button background */
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .header-auth-button:hover {
            background-color: #555; /* Darker hover */
        }

        /* Main Content Area */
        main.content-area {
            flex: 1; /* Allows main content to grow and push footer down */
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff; /* White background for page content */
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        /* Footer Styles */
        footer {
            background-color: #000; /* Black background for the footer */
            color: #fff;
            padding: 40px 0;
        }
        .footer-container {
            max-width: 1200px; /* Match header container width */
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap; /* Allows items to wrap on smaller screens */
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        .footer-logo {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
            flex: 1 1 150px; /* Allow logo to take flexible width */
            min-width: 100px;
        }
        .footer-company-name {
            font-size: 18px;
            flex: 2 1 200px; /* Allow company name to take flexible width */
            text-align: center;
            margin-top: 5px; /* Adjust spacing */
        }
        .footer-social-icons {
            flex: 1 1 100px; /* Allow icons to take flexible width */
            text-align: right;
        }
        .social-icon-box {
            display: inline-block;
            background-color: #333; /* Dark gray for social icon boxes */
            color: #fff;
            padding: 8px 12px;
            margin-left: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .social-icon-box:hover {
            background-color: #555;
        }
        .footer-separator {
            width: 100%;
            height: 1px;
            background-color: #333; /* Dark gray line */
            margin: 20px 0;
        }
        .footer-bottom-company-name {
            width: 100%;
            text-align: left;
            font-size: 14px;
            color: #ccc; /* Lighter gray for bottom text */
        }

        /* Responsive adjustments (basic) */
        @media (max-width: 768px) {
            .header-container, .footer-container {
                flex-direction: column;
                text-align: center;
            }
            .header-nav ul {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
            .header-nav, .header-auth-button {
                margin-top: 10px;
            }
            .footer-company-name, .footer-social-icons {
                text-align: center;
                width: 100%; /* Take full width on small screens */
            }
            .social-icon-box {
                margin: 0 5px; /* Adjust spacing */
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="/" class="header-logo">Logo</a>
            <nav class="header-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/attractions">Tourist Attraction</a></li>
                    <li><a href="/accommodations">Accommodation</a></li>
                    <li><a href="/products">Products</a></li> {{-- Placeholder --}}
                    <li><a href="/transaction">Transaction</a></li> {{-- Placeholder --}}
                </ul>
            </nav>
            <a href="/login" class="header-auth-button">Login/Register</a>
        </div>
    </header>

    <main class="content-area">
        @yield('content') {{-- This is where individual page content will go --}}
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-logo">Logo</div>
            <div class="footer-company-name">Company Name</div>
            <div class="footer-social-icons">
                <a href="#" class="social-icon-box">WA</a>
                <a href="#" class="social-icon-box">IG</a>
                <a href="#" class="social-icon-box">YT</a>
            </div>
            <div class="footer-separator"></div>
            <div class="footer-bottom-company-name">Company Name</div>
        </div>
    </footer>
</body>
</html>