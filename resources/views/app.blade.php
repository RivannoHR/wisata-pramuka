<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pulau Pramuka Travel')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        
        /* Carousel Styles */
        .carousel-container {
            position: relative;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 50px; 
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
            height: 350px; 
        }

        .carousel-slide {
            min-width: 100%;
            flex: 0 0 100%; 
            padding: 0 10px;
            box-sizing: border-box;
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }   

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 15px;
            cursor: pointer;
            border-radius: 50%;
            font-size: 18px;
            z-index: 10;
            transition: background-color 0.3s ease;
        }

        .carousel-button:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .carousel-button.prev {
            left: 0;
        }

        .carousel-button.next {
            right: 0;
        }

        .carousel-dots {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dot.active {
            background-color: #007bff;
        }

        /* Adjust product point item for carousel */
        .product-point-item {
            margin: 10px;
            flex: 1; 
            display: flex;
            flex-direction: row;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Fixed size for carousel cards */
            min-height: 300px;
            max-height: 300px;
            width: 100%;
            max-width: 600px; 
            gap: 20px; 
            align-items: stretch; 
        }

        body {
            font-family: 'Inter', sans-serif; /* Changed to Inter */
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styles */
        header {
            background-color: #fff; 
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        }
        .header-container {
            max-width: 1200px; 
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
            gap: 20px; 
        }
        .header-nav ul li a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            padding: 5px 0;
            transition: color 0.3s ease;
        }
        .header-nav ul li a:hover {
            color: #007bff; 
        }
        .header-auth-button {
            background-color: #333; 
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

        /* Page Content Wrapper */
        .page-content {
            flex: 1; /* Takes up remaining space, pushing footer down */
            display: flex;
            flex-direction: column;
        }

        /* Main Content Area */
        main.content-area {
            flex: 1; /* Allows main content to grow within page-content */
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
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

        /* Hero Section Styles */
        .hero-section-wrapper {
            min-height: 400px; /* Adjust height as needed for your design */
            display: flex; /* Use flexbox to align content */
            align-items: flex-end; /* Align content to the bottom */
            justify-content: center; /* Center horizontally */
            padding: 40px 20px; /* Padding for content */
            box-sizing: border-box; /* Include padding in height calculation */
            /* This is the gradient background */
            background: linear-gradient(to bottom, #ffffff 0%, #f0f0f0 50%, #555555 100%);
            color: #fff; /* Default text color for hero content */
            text-align: center;
        }

        .hero-content {
            max-width: 800px; /* Constrain text width for readability */
            margin-bottom: 20px; /* Space from the very bottom of the section */
        }

        .hero-content h1 {
            font-size: 48px; 
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Responsive adjustments for Hero section */
        @media (max-width: 768px) {
            .hero-section-wrapper {
                min-height: 300px;
                padding: 20px;
            }
            .hero-content h1 {
                font-size: 32px; /* Adjusted responsive font size to a fixed pixel value for mobile */
            }
        }

        /* Products Section Styles */
        .products-section {
            padding: 40px 0; /* Padding for the section */
        }

        .section-header {
            display: flex; /* Use flexbox to align icon and text */
            align-items: center; /* Vertically align them */
            justify-content: center; /* Center them horizontally */
            margin-bottom: 30px; /* Space below the header */
        }

        .icon-circle {
            display: inline-flex; /* Allows custom styling for a small circle */
            align-items: center;
            justify-content: center;
            width: 40px; /* Size of the circle */
            height: 40px;
            border-radius: 50%; /* Makes it a circle */
            background-color: #007bff; /* Bright blue background as per screenshot */
            color: #fff; /* White icon color */
            font-size: 18px; /* Icon size */
            margin-right: 15px; /* Space between icon and text */
            box-shadow: 0 2px 5px rgba(0,0,0,0.2); /* Subtle shadow for depth */
        }

        .section-header h2 {
            font-size: 32px; /* Adjust font size as needed */
            font-weight: bold;
            color: #333;
            margin: 0; /* Remove default margin from h2 */
        }

        .product-points-grid {
            display: grid; /* Use CSS Grid for a flexible layout of points */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* 3 columns on larger screens, flexible */
            gap: 20px; /* Space between grid items */
            padding: 0 20px; /* Padding for the grid inside the container */
        }

        .product-point-item:hover {
            transform: translateY(-5px); /* Slight lift on hover */
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-point-item h3 {
            font-size: 22px;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .product-point-item p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            flex-grow: 1; /* Allow description to fill available space */
            overflow: hidden; /* Hide overflow text */
            display: -webkit-box;
            -webkit-line-clamp: 6; /* Limit to 6 lines */
            -webkit-box-orient: vertical;
        }

        /* Product content and image layout for carousel */
        .product-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0; /* Allow content to shrink */
        }

        /* Product header with ID and stock */
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .product-id {
            font-size: 12px;
            font-weight: 600;
            color: #007bff;
            background-color: #e7f3ff;
            padding: 4px 8px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .stock-info {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        .stock-info.in-stock {
            color: #28a745;
            background-color: #e8f5e8;
        }

        .stock-info.out-of-stock {
            color: #dc3545;
            background-color: #fdeaea;
        }

        /* Product actions */
        .product-actions {
            margin-top: auto;
            padding-top: 15px;
        }

        .product-button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: auto;
            min-width: 80px;
        }

        .product-button:hover {
            background-color: #333;
        }

        .product-image {
            flex: 0 0 200px; /* Fixed width for image container */
            width: 200px;
            height: 100%; /* Full height of parent */
            max-height: 260px; /* Adjust to fit within card height minus padding */
            overflow: hidden;
            border-radius: 6px;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Placeholder for missing images */
        .product-image.placeholder {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 200px;
            width: 200px;
            height: 100%;
            max-height: 260px;
        }

        .placeholder-text {
            color: #6c757d;
            font-size: 14px;
            font-style: italic;
        }

        /* Responsive adjustments for products section */
        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 28px; /* Smaller heading on mobile */
            }
            .product-points-grid {
                grid-template-columns: 1fr; /* Single column on very small screens */
                padding: 0 10px;
            }
            
            /* Mobile adjustments for carousel cards */
            .carousel-track {
                height: 400px; /* Adjusted height for mobile */
            }
            
            .product-point-item {
                flex-direction: column; /* Stack vertically on mobile */
                min-height: 360px;
                max-height: 360px;
                max-width: 300px;
                gap: 15px;
                align-items: center;
            }
            
            .product-image, .product-image.placeholder {
                flex: 0 0 150px;
                width: 100%;
                max-height: 150px;
                height: 150px;
            }
            
            .product-content {
                text-align: center;
                width: 100%;
            }
            
            .product-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .product-button {
                font-size: 12px;
                padding: 8px 16px;
            }
        }


        <!-- Login page -->
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .login-box p {
            color: #666;
            margin-bottom: 30px;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .login-form input:focus {
            outline: none;
            border-color: black;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background:rgba(255, 255, 255, 0.95);
            border: 1px solid #ddd;
            color: #666;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
        }

        .login-button:hover {
            background:black;
            color: #fff;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
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
            @auth
                <a href="/profile" class="header-auth-button">{{ Auth::user()->name }}</a>
            @else
                <a href="/login" class="header-auth-button">Login/Register</a>
            @endauth
        </div>
    </header>

    <div class="page-content">
        @hasSection('hero_content')
            <div class="hero-section-wrapper">
                @yield('hero_content')
            </div>
        @endif

        <main class="content-area">
            @yield('content') {{-- Existing placeholder for main page content --}}
        </main>
    </div>

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
    
    {{-- Carousel Section --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSlide = 0;
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.dot');
            const track = document.querySelector('.carousel-track');

            function updateCarousel() {
                // Update slide position
                track.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
            }

            window.moveCarousel = function(direction) {
                currentSlide = (currentSlide + direction + slides.length) % slides.length;
                updateCarousel();
            }

            window.goToSlide = function(slideIndex) {
                currentSlide = slideIndex;
                updateCarousel();
            }

            // Initialize the carousel
            updateCarousel();

            // Optional: Auto-play
            setInterval(() => {
                moveCarousel(1);
            }, 5000);
        });
    </script>
</body>
</html>
