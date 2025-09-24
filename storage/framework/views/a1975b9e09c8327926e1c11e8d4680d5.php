<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Pulau Pramuka Travel'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

        /* Horizontal Scroll Styles for Products */
        .horizontal-scroll-container {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        .horizontal-scroll-track {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 0 20px 20px 20px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .horizontal-scroll-track::-webkit-scrollbar {
            height: 8px;
        }

        .horizontal-scroll-track::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .horizontal-scroll-track::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .horizontal-scroll-track::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        .horizontal-product-card {
            flex: 0 0 280px;
            width: 280px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .horizontal-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .horizontal-product-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .horizontal-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .horizontal-product-card:hover .horizontal-product-image img {
            transform: scale(1.05);
        }

        .horizontal-product-image .placeholder-image {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .horizontal-product-image .placeholder-image i {
            font-size: 48px;
        }

        .horizontal-product-content {
            padding: 20px;
        }

        .horizontal-product-content h3 {
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.3;
        }

        .horizontal-product-description {
            margin: 0 0 12px 0;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.5;
        }

        .horizontal-product-price {
            margin: 12px 0;
            font-size: 16px;
            font-weight: 700;
            color: #27ae60;
        }

        .horizontal-product-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .horizontal-view-button, .horizontal-order-button {
            flex: 1;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }

        .horizontal-view-button-single {
            width: 100%;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            display: inline-block;
            box-sizing: border-box;
        }

        .horizontal-view-button-single:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-1px);
            color: white;
            text-decoration: none;
        }

        .horizontal-view-button {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #e9ecef;
        }

        .horizontal-view-button:hover {
            background: #e9ecef;
            text-decoration: none;
            color: #333;
        }

        .horizontal-order-button {
            background: #25d366;
            color: white;
        }

        .horizontal-order-button:hover {
            background: #1fa851;
            text-decoration: none;
            color: white;
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-products i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .no-products h3 {
            margin: 0 0 12px 0;
            font-size: 24px;
            color: #495057;
        }

        .no-products p {
            margin: 0;
            font-size: 16px;
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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
            font-family: 'Inter', sans-serif;
            /* Changed to Inter */
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1000;
            order: -1;
            /* Ensure header comes first in flexbox */
        }

        .header-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 10px 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo img {
            height: 70px;
            width: auto;
            object-fit: contain;
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
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-auth-button:hover {
            background-color: #555;
            /* Darker hover */
            text-decoration: none;
            color: #fff;
        }

        /* User Dropdown Styles */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle i {
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .dropdown-toggle.active i {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 1px solid #e5e7eb;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: #1a1a1a;
            text-decoration: none;
        }

        .dropdown-item i {
            width: 16px;
            color: #6b7280;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 8px 0;
        }

        .logout-btn {
            color: #dc2626 !important;
            font-weight: 500;
        }

        .logout-btn:hover {
            background-color: #fef2f2 !important;
            color: #b91c1c !important;
        }

        .logout-btn i {
            color: #dc2626 !important;
        }

        /* Visit Counter Styles */
        .visit-counter {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(51, 51, 51, 0.08);
            padding: 8px 14px;
            border-radius: 18px;
            font-size: 14px;
            color: #555;
            border: 1px solid rgba(51, 51, 51, 0.15);
            white-space: nowrap;
            min-width: 85px;
            justify-content: center;
        }

        .visit-counter i {
            color: #666;
            font-size: 12px;
        }

        .visit-count {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        /* Page Content Wrapper */
        .page-content {
            flex: 1;
            /* Takes up remaining space, pushing footer down */
            display: flex;
            flex-direction: column;
            order: 0;
            /* Ensure content comes after header */
        }

        /* Main Content Area */
        main.content-area {
            flex: 1;
            /* Allows main content to grow within page-content */
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /* Footer Styles */
        footer {
            background-color: #000;
            /* Black background for the footer */
            color: #fff;
            padding: 40px 0;
            order: 1;
            /* Ensure footer comes last */
        }

        .footer-container {
            max-width: 1200px;
            /* Match header container width */
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }

        .footer-content-top {
            display: flex;
            justify-content: space-between;
        }

        .footer-logo img {
            height: 70px;
            width: auto;
            object-fit: contain;
        }

        .footer-company-name {
            font-size: 20px;
            font-weight: 600;
        }

        .footer-social-icons {
            text-align: right;
        }

        .social-icon-box {
            display: inline-block;
            background-color: #333;
            /* Dark gray for social icon boxes */
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
            background-color: #333;
            /* Dark gray line */
            margin: 20px 0;
        }

        .footer-content-bottom {
            text-align: left;
            font-size: 14px;
            color: #ccc;
            /* Lighter gray for bottom text */
        }

        /* Responsive adjustments (basic) */
        @media (max-width: 768px) {

            .header-container,
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .header-nav ul {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }

            .header-nav,
            .header-auth-button {
                margin-top: 10px;
            }

            .header-right {
                flex-direction: column;
                gap: 10px;
                margin-top: 15px;
            }

            .visit-counter {
                justify-content: center;
                font-size: 13px;
                padding: 6px 12px;
                min-width: 80px;
            }

            .user-dropdown {
                margin-top: 10px;
            }

            .dropdown-menu {
                right: 0;
                left: auto;
                min-width: 180px;
            }

            .footer-company-name,
            .footer-social-icons {
                text-align: center;
                width: 100%;
                /* Take full width on small screens */
            }

            .social-icon-box {
                margin: 0 5px;
                /* Adjust spacing */
            }

        }

        .hero-section-wrapper {
            min-height: 400px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 40px 20px;
            box-sizing: border-box;
            background-image: linear-gradient(rgba(115, 115, 115, 0) 15%, rgba(0, 0, 0, 0.75) 100%),
                url("storage/pulau-pramuka.jpg");
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            /* Constrain text width for readability */
            margin-bottom: 20px;
            /* Space from the very bottom of the section */
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .hero-content p {
            font-size: 20px;
            font-weight: 300;
            line-height: 1.5;
            margin-bottom: 0;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            opacity: 0.95;
        }

        /* Responsive adjustments for Hero section */
        @media (max-width: 768px) {
            .hero-section-wrapper {
                min-height: 300px;
                padding: 20px;
            }

            .hero-content h1 {
                font-size: 32px;
                /* Adjusted responsive font size to a fixed pixel value for mobile */
            }

            .hero-content p {
                font-size: 16px;
            }
        }

        /* Products Section Styles */
        .products-section {
            padding: 40px 0;
            /* Padding for the section */
        }

        .section-header {
            display: flex;
            /* Use flexbox to align icon and text */
            align-items: center;
            /* Vertically align them */
            justify-content: center;
            /* Center them horizontally */
            margin-bottom: 30px;
            /* Space below the header */
        }

        .icon-circle {
            display: inline-flex;
            /* Allows custom styling for a small circle */
            align-items: center;
            justify-content: center;
            width: 40px;
            /* Size of the circle */
            height: 40px;
            border-radius: 50%;
            /* Makes it a circle */
            background-color: #007bff;
            /* Bright blue background as per screenshot */
            color: #fff;
            /* White icon color */
            font-size: 18px;
            /* Icon size */
            margin-right: 15px;
            /* Space between icon and text */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* Subtle shadow for depth */
        }

        .section-header h2 {
            font-size: 32px;
            /* Adjust font size as needed */
            font-weight: bold;
            color: #333;
            margin: 0;
            /* Remove default margin from h2 */
        }

        .product-points-grid {
            display: grid;
            /* Use CSS Grid for a flexible layout of points */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            /* 3 columns on larger screens, flexible */
            gap: 20px;
            /* Space between grid items */
            padding: 0 20px;
            /* Padding for the grid inside the container */
        }

        .product-point-item:hover {
            transform: translateY(-5px);
            /* Slight lift on hover */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            flex-grow: 1;
            /* Allow description to fill available space */
            overflow: hidden;
            /* Hide overflow text */
            display: -webkit-box;
            -webkit-line-clamp: 6;
            /* Limit to 6 lines */
            -webkit-box-orient: vertical;
        }

        /* Product content and image layout for carousel */
        .product-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            /* Allow content to shrink */
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
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .product-button:hover {
            background-color: #333;
            color: #fff;
        }

        .product-image {
            flex: 0 0 200px;
            /* Fixed width for image container */
            width: 200px;
            height: 100%;
            /* Full height of parent */
            max-height: 260px;
            /* Adjust to fit within card height minus padding */
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
                font-size: 28px;
                /* Smaller heading on mobile */
            }

            .product-points-grid {
                grid-template-columns: 1fr;
                /* Single column on very small screens */
                padding: 0 10px;
            }

            /* Mobile adjustments for carousel cards */
            .carousel-track {
                height: 400px;
                /* Adjusted height for mobile */
            }

            .product-point-item {
                flex-direction: column;
                /* Stack vertically on mobile */
                min-height: 360px;
                max-height: 360px;
                max-width: 300px;
                gap: 15px;
                align-items: center;
            }

            .product-image,
            .product-image.placeholder {
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

            /* Mobile styles for horizontal scroll products */
            .horizontal-scroll-track {
                padding: 0 15px 20px 15px;
                gap: 15px;
            }

            .horizontal-product-card {
                flex: 0 0 250px;
                width: 250px;
            }

            .horizontal-product-image {
                height: 160px;
            }

            .horizontal-product-content {
                padding: 15px;
            }

            .horizontal-product-content h3 {
                font-size: 16px;
            }

            .horizontal-product-description {
                font-size: 13px;
            }

            .horizontal-product-price {
                font-size: 15px;
            }

            .horizontal-product-actions {
                flex-direction: column;
                gap: 8px;
            }

            .horizontal-view-button, .horizontal-order-button {
                padding: 8px 14px;
                font-size: 13px;
            }

            .horizontal-view-button-single {
                padding: 8px 14px;
                font-size: 13px;
            }
        }


        < !-- Login page -->.login-container {
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
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #ddd;
            color: #666;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
        }

        .login-button:hover {
            background: black;
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

        /* Checkbox Styles */
        .checkbox-group {
            margin-bottom: 20px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #666;
            font-size: 14px;
            user-select: none;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }

        .checkbox-label:hover {
            color: #333;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        /* Products Page Styles */
        .products-page-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .products-header {
            margin-bottom: 40px;
        }

        .products-header h1 {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .filter-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: center;
        }

        .filter-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-input,
        .filter-select,
        .price-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            min-width: 120px;
        }

        .search-input {
            min-width: 200px;
        }

        .price-input {
            min-width: 100px;
        }

        .filter-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .filter-button {
            background: black;
            color: white;
        }

        .filter-button:hover {
            background: #555;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .product-card-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card-image.placeholder {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eee;
        }

        .product-card-content {
            padding: 20px;
        }

        .product-card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .product-card-description {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .product-card-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }

        .product-stock {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .product-stock.in-stock {
            background: #d4edda;
            color: #155724;
        }

        .product-stock.low-stock {
            background: #fff3cd;
            color: #856404;
        }

        .product-stock.out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }

        .product-card-actions {
            display: flex;
            gap: 10px;
        }

        .view-button,
        .add-to-cart-button,
        .order-button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            flex: 1;
        }

        .view-button {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .view-button:hover {
            background: #e9ecef;
        }

        .add-to-cart-button,
        .order-button {
            background: #25d366;
            color: white;
        }

        .add-to-cart-button:hover,
        .order-button:hover {
            background: #1fa851;
            text-decoration: none;
            color: white;
        }

        .add-to-cart-button.disabled,
        .order-button.disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .no-products {
            text-align: center;
            padding: 100px 20px;
            color: #666;
            font-size: 18px;
            grid-column: 1 / -1;
            /* Take full width of the grid */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }

        .no-products p {
            margin: 0;
            font-weight: 500;
        }

        /* Product Detail Page */
        .product-detail-section {
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-button {
            color: black;
            text-decoration: none;
            margin-bottom: 30px;
            display: inline-block;
            font-weight: 600;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
            margin-top: 20px;
        }

        .product-detail-image {
            width: 100%;
            height: 400px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-detail-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-image {
            background: #f8f9fa;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .product-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            margin-top: 0;
        }

        .product-detail-info .product-price {
            font-size: 28px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 20px;
        }

        .product-stock-status {
            margin-bottom: 20px;
        }

        .stock-badge {
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .stock-badge.in-stock {
            background: #d4edda;
            color: #155724;
        }

        .stock-badge.low-stock {
            background: #fff3cd;
            color: #856404;
        }

        .stock-badge.out-of-stock {
            background: #f8d7da;
            color: #721c24;
        }

        .product-description {
            margin-bottom: 30px;
        }

        .product-description h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .product-description p {
            line-height: 1.6;
            color: #666;
        }

        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-input {
            width: 80px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .product-detail-image {
                height: 300px;
            }

            .product-title {
                font-size: 24px;
            }

            .product-detail-info .product-price {
                font-size: 24px;
            }
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        /* Error Popup Styles */
        .error-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .error-popup {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .error-popup-header {
            padding: 20px 20px 10px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .error-popup-header h3 {
            margin: 0;
            color: #dc3545;
            font-size: 20px;
            font-weight: 600;
        }

        .close-popup {
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .close-popup:hover {
            background-color: #f8f9fa;
            color: #666;
        }

        .error-popup-body {
            padding: 20px;
            text-align: center;
        }

        .error-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .error-popup-body p {
            color: #666;
            font-size: 16px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 15px;
        }

        .error-list li {
            color: #721c24;
            font-size: 14px;
            margin-bottom: 5px;
            position: relative;
            padding-left: 20px;
        }

        .error-list li:before {
            content: "•";
            color: #dc3545;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .error-list li:last-child {
            margin-bottom: 0;
        }

        .error-popup-footer {
            padding: 10px 20px 20px 20px;
            text-align: center;
        }

        .popup-button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            min-width: 120px;
        }

        .popup-button:hover {
            background: #c82333;
        }

        /* Enhanced form error styles */
        .form-group {
            position: relative;
        }

        .form-group .error {
            display: block;
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Input error state */
        .form-group input.error-input {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
        }

        /* Responsive popup */
        @media (max-width: 480px) {
            .error-popup {
                margin: 20px;
                width: calc(100% - 40px);
            }

            .error-popup-header h3 {
                font-size: 18px;
            }

            .error-icon {
                font-size: 36px;
            }

            .error-popup-body p {
                font-size: 14px;
            }
        }

        /* Homepage Accommodations and Attractions Sections */
        .accommodations-section,
        .attractions-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        .accommodations-section:nth-of-type(even),
        .attractions-section:nth-of-type(even) {
            background-color: #ffffff;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .card-image img {
            transform: scale(1.05);
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
        }

        .card-content {
            padding: 25px;
        }

        .card-content h3 {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .card-location {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .card-location i {
            color: #e74c3c;
        }

        .card-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #7f8c8d;
            font-size: 13px;
        }

        .meta-item i {
            color: #3498db;
        }

        .meta-price {
            font-weight: 600;
            color: #27ae60;
            font-size: 16px;
        }

        .meta-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #f39c12;
            font-size: 14px;
            font-weight: 500;
        }

        .meta-rating i {
            color: #f39c12;
        }

        .type-badge {
            background: #ecf0f1;
            color: #2c3e50;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: capitalize;
        }

        .type-badge.beach {
            background: #e8f4fd;
            color: #2980b9;
        }

        .type-badge.cultural {
            background: #fdf2e9;
            color: #e67e22;
        }

        .type-badge.adventure {
            background: #eafaf1;
            color: #27ae60;
        }

        .type-badge.nature {
            background: #f4e8fd;
            color: #8e44ad;
        }

        .card-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .card-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .view-all-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #667eea;
            text-decoration: none;
            padding: 15px 30px;
            border: 2px solid #667eea;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-all-button:hover {
            background: #667eea;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .article-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 123, 255, 0.9);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Responsive adjustments for homepage cards */
        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 0 15px;
            }

            .accommodations-section,
            .attractions-section,
            .products-section {
                padding: 30px 0;
                max-width: 650px;
            }

            .card-content {
                padding: 20px;
            }

            .section-header h2 {
                font-size: 24px;
            }
        }
    </style>

</head>

<body>
    <header>
        <div class="header-container">
            <a href="/" class="header-logo">
                <img src="<?php echo e(asset('storage/logo.png')); ?>" style="object-fit: contain">
            </a>
            <nav class="header-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/tourist-attractions">Tourist Attraction</a></li>
                    <li><a href="/accommodations">Accommodation</a></li>
                    <li><a href="/products">Products</a></li>
                    <li><a href="<?php echo e(route('articles.index')); ?>">News</a></li>
                    <?php if(auth()->guard()->check()): ?>
                    <li><a href="/transactions">Transaction</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="header-right">
                <?php if(auth()->guard()->check()): ?>
                <div class="user-dropdown">
                    <button class="header-auth-button dropdown-toggle" onclick="toggleDropdown()">
                        <?php echo e(Auth::user()->username ?: Auth::user()->name); ?>

                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="<?php echo e(route('profile.show')); ?>" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <a href="/login" class="header-auth-button">Login/Register</a>
                <?php endif; ?>

                <!-- Visit Counter -->
                <div class="visit-counter">
                    <i class="fas fa-eye"></i>
                    <span class="visit-count"><?php echo e($formattedVisits); ?></span>
                    <span>visits</span>
                </div>
            </div>
        </div>
    </header>

    <div class="page-content">
        <?php if (! empty(trim($__env->yieldContent('hero_content')))): ?>
        <div class="hero-section-wrapper">
            <?php echo $__env->yieldContent('hero_content'); ?>
        </div>
        <?php endif; ?>

        <main class="content-area">
            <?php echo $__env->yieldContent('content'); ?> 
        </main>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-content-top">
                <div class="footer-logo">
                    <img src="<?php echo e(asset('storage/logo.png')); ?>">
                </div>
                <div class="footer-company-name">Rumah Literasi Hijau</div>
                <div class="footer-social-icons">
                    <a href="http://wa.me/6281213643354" class="social-icon-box">
                        <img src="<?php echo e(asset('images/whatsapp-icon.svg')); ?>" alt="WhatsApp" style="width: 20px; height: 20px; filter: invert(1);">
                    </a>
                    <a href="https://www.instagram.com/rumahliterasihijau_id?igsh=MWU4MjlvZDRkcWxvag==" class="social-icon-box" target="_blank">
                        <img src="<?php echo e(asset('images/instagram-icon.svg')); ?>" alt="Instagram" style="width: 20px; height: 20px; filter: invert(1);">
                    </a>
                </div>
            </div>
            <div class="footer-separator"></div>
            <div class="footer-content-bottom">
                Rumah Literasi Hijau
            </div>
        </div>
    </footer>


    <script>
        // User dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const toggle = document.querySelector('.dropdown-toggle');

            dropdown.classList.toggle('show');
            toggle.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const toggle = document.querySelector('.dropdown-toggle');

            if (dropdown && !dropdown.contains(event.target) && !toggle.contains(event.target)) {
                dropdown.classList.remove('show');
                toggle.classList.remove('active');
            }
        });
    </script>
</body>

</html><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/app.blade.php ENDPATH**/ ?>