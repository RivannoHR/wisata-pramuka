<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pulau Pramuka Travel')</title>
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
        /* Prevent layout width from shifting between routes when a vertical scrollbar
           appears/disappears. Use CSS gutter where supported, and force a reserved
           vertical scrollbar track everywhere else (covers Safari, older browsers). */
        html {
            scrollbar-gutter: stable both-edges; /* supported in Chromium/Firefox */
            overflow-x: hidden; /* iOS Safari sometimes ignores body-only rule */
        }
        /* Always reserve a vertical scrollbar to avoid "page jump" in browsers
           that don't honor scrollbar-gutter consistently (notably Safari). */
        body {
            overflow-y: scroll;
            overflow-x: hidden; /* avoid tiny left/right overflow from full-bleed sections */
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
            padding-top: 90px; /* Account for fixed header height */
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Base Styles */
        header {
            background-color: #ffffff; /* solid white header on all devices */
            /* removed backdrop blur/transparency for crisp white */
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            /* Ensure header stays above any side panels/overlays */
            z-index: 3000;
            order: -1;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
            padding: 5px;
        }

        /* Logo */
        .header-logo {
            display: flex;
            align-items: center;
        }

        .header-logo img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        /* Desktop Navigation */
        .desktop-nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .desktop-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 30px;
        }

        .desktop-nav ul li a {
            color: #333;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .desktop-nav ul li a:hover {
            background-color: #f8f9fb;
            color: #2c5f2d;
        }

        /* Mobile Navigation (Initially Hidden) */
        .mobile-nav {
            display: none;
        }

        .header-auth-button {
            background-color: #2c5f2d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .header-auth-button:hover {
            background-color: #1e4620;
            text-decoration: none;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(44, 95, 45, 0.3);
        }

        /* Mobile Hamburger Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-direction: column;
            justify-content: center;
            gap: 3px;
            width: 35px;
            height: 35px;
        }

        .hamburger-line {
            width: 20px;
            height: 2px;
            background-color: #333;
            transition: all 0.3s ease;
        }

        /* DESKTOP Header (769px and above) */
        @media (min-width: 769px) {
            /* Keep items spaced evenly with a consistent gap */
            .header-container {
                gap: 24px;
            }

            /* Make nav size to its content and remove auto-centering behavior */
            .desktop-nav {
                flex: 0 0 auto;
                margin: 0; /* gap drives spacing */
                display: block !important;
                justify-content: initial !important;
            }

            /* Ensure logo doesn't add extra margin */
            .header-logo { margin-right: 0; }

            .mobile-menu-toggle {
                display: none !important;
            }

            .desktop-nav {
                display: block !important;
                margin-left: 0; /* ensure no extra shift beyond logo spacing */
            }

            .desktop-nav ul {
                display: flex !important;
                flex-direction: row !important;
            }

            .desktop-nav ul li {
                border-bottom: none !important;
            }

            .desktop-nav ul li a {
                padding: 5px 0 !important;
                display: inline !important;
            }

            .desktop-nav ul li a:hover {
                background-color: transparent !important;
            }
        }

        /* MOBILE Header (768px and below) */
        @media (max-width: 768px) {
            body {
                padding-top: 80px; /* Mobile header padding */
            }
            /* Ensure main content aligns with header/footer edges on mobile */
            main.content-area {
                padding-left: 16px;
                padding-right: 16px;
                margin-left: auto;
                margin-right: auto;
                width: 100%
                box-sizing: border-box;
            }

            /* Use 3-column grid so logo stays perfectly centered */
            .header-container {
                padding: 0 12px;
                height: 60px;
                position: relative;
                display: grid;
                grid-template-columns: 1fr auto 1fr; /* left | center | right */
                align-items: center;
            }

            /* LEFT: hamburger */
            .mobile-menu-toggle {
                display: flex !important;
                grid-column: 1;
                justify-self: start;
                z-index: 1001;
                flex-shrink: 0;
            }

            /* CENTER: logo */
            .header-logo {
                position: static;
                transform: none;
                grid-column: 2;
                justify-self: center;
                z-index: 1000;
            }

            .header-logo img {
                height: 40px;
            }

            /* Hide desktop navigation on mobile */
            .desktop-nav {
                display: none;
            }

            /* RIGHT: auth + visits (in a row) */
            .header-right {
                grid-column: 3;
                justify-self: end;
                z-index: 1001;
                display: flex;
                flex-direction: row; /* horizontal distribution */
                align-items: center;
                gap: 8px;
                flex-shrink: 0;
            }

            .header-auth-button {
                padding: 6px 12px;
                font-size: 12px;
                border-radius: 15px;
                white-space: nowrap;
            }

            .visit-counter {
                padding: 4px 8px;
                font-size: 11px;
                border-radius: 12px;
                min-width: auto;
                gap: 4px;
            }

            .visit-counter i {
                font-size: 10px;
            }

            .visit-count {
                font-size: 11px;
            }

            /* Hide visit counter on mobile */
            .visit-counter {
                display: none !important;
            }
        }

            /* Hide desktop navigation on mobile */
            .desktop-nav {
                display: none;
            }

            /* Show mobile navigation */
            .mobile-nav {
                display: block;
                position: fixed;
                /* Start below the fixed header */
                top: 60px;
                left: -280px;
                width: 280px;
                height: calc(100vh - 60px);
                background-color: #fff;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
                transition: left 0.3s ease;
                /* Keep below the header but above the overlay */
                z-index: 2000;
                overflow-y: auto;
                padding-top: 20px;
            }

            .mobile-nav.active {
                left: 0;
            }

            .mobile-nav ul {
                list-style: none;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
            }

            .mobile-nav ul li {
                border-bottom: 1px solid #eee;
            }

            .mobile-nav ul li:last-child {
                border-bottom: none;
            }

            .mobile-nav ul li a {
                color: #333;
                text-decoration: none;
                font-size: 16px;
                padding: 18px 25px;
                display: block;
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .mobile-nav ul li a:hover {
                background-color: #f8f9fa;
                color: #007bff;
                border-left-color: #007bff;
            }

            /* Sidebar overlay */
            .sidebar-overlay {
                position: fixed;
                /* Do not cover the fixed header */
                top: 60px;
                left: 0;
                /* Use percentage width to avoid including the scrollbar width
                   on platforms where 100vw causes a tiny horizontal shift */
                width: 100%;
                height: calc(100vh - 60px);
                background-color: rgba(0, 0, 0, 0.5);
                /* Below the header so header stays visible and interactive */
                z-index: 1990;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Sidebar header */
            .sidebar-header {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 80px;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 25px;
                border-bottom: 1px solid #eee;
            }

            .sidebar-header .logo {
                height: 35px;
            }

            .sidebar-close {
                background: none;
                border: none;
                font-size: 24px;
                color: #666;
                cursor: pointer;
                padding: 5px;
                line-height: 1;
            }

            .header-right {
                order: 3;
            }

            .header-auth-button {
                background-color: #333;
                color: #fff;
                padding: 8px 12px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 12px;
                transition: background-color 0.3s ease;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .header-auth-button:hover {
                background-color: #555;
                text-decoration: none;
                color: #fff;
            }

            /* When sidebar is open, prevent header buttons from interacting/highlighting */
            body.menu-open .header-right .header-auth-button,
            body.menu-open .header-right .header-auth-button:hover,
            body.menu-open .header-right .header-auth-button:focus,
            body.menu-open .header-right .header-auth-button:active {
                /* Allow header interactions even when menu is open */
                pointer-events: auto;
                transform: none !important;
                box-shadow: none !important;
                filter: none !important;
            }

            /* Explicitly ensure the entire header remains interactive above overlay */
            body.menu-open header,
            body.menu-open .header-container,
            body.menu-open .mobile-menu-toggle,
            body.menu-open .header-right,
            body.menu-open .header-right * {
                pointer-events: auto !important;
            }
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
            align-items: stretch; /* ensure children expand full width */
            order: 0;
            /* Ensure content comes after header */
            overflow-x: hidden; /* guard against any child horizontal bleed */
        }

        /* Main Content Area */
        main.content-area {
            flex: 1;
            /* Allows main content to grow within page-content */
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /* Footer Base Styles */
        footer {
            background-color: #000;
            color: #fff;
            padding: 20px 0;
            order: 1;
        }

        /* DESKTOP Footer (769px and above) - Original Design */
        @media (min-width: 769px) {
            .footer-mobile-only { display: none; }
            .footer-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .footer-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }

            .footer-left-top {
                display: flex;
                align-items: center;
            }

            .footer-bottom {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .footer-left {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .footer-logo img {
                height: 50px;
                width: auto;
                object-fit: contain;
            }

            .footer-company-name {
                font-size: 14px;
                color: #ccc;
                font-weight: 400;
            }

            .footer-center {
                flex: 1;
                text-align: center;
            }

            .footer-center-title {
                font-size: 18px;
                font-weight: 600;
                color: #fff;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .footer-center-title:hover {
                color: #4CAF50;
            }

            .footer-right-top, .footer-right-bottom {
                display: flex;
                align-items: center;
            }

            .footer-separator {
                width: 100%;
                height: 1px;
                background-color: #444;
                margin: 15px 0;
            }

            .footer-funding-text {
                font-size: 14px;
                color: #ccc;
                font-weight: 400;
            }

            .footer-social-icons {
                display: flex;
                gap: 10px;
                align-items: center;
            }

            .social-icon-box {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background-color: #333;
                color: #fff;
                width: 32px;
                height: 32px;
                border-radius: 6px;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .social-icon-box:hover {
                background-color: #555;
            }

            .social-icon-box img {
                width: 18px;
                height: 18px;
                filter: invert(1);
            }

            /* Hide mobile-only elements on desktop */
            .footer-logo-section,
            .footer-brand-name,
            .footer-container > .footer-funding-text {
                display: none;
            }
        }

    /* MOBILE Footer (768px and below) - Current Design */
        @media (max-width: 768px) {
            .footer-mobile-only { display: block; }
            /* Make footer span full viewport width on mobile instead of a narrow card */
            .footer-container {
                max-width: none;        /* remove the 400px cap */
                width: 100%;            /* take full width */
                margin: 0;              /* no auto-centering gutter */
                padding: 24px 12px;     /* match header side padding */
                text-align: center;
                box-sizing: border-box; /* include padding in width */
            }

            .footer-logo-section {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 20px;
            }

            .footer-logo img {
                height: 28px; /* was 40px: reduce size on mobile */
                width: auto;
                object-fit: contain;
                margin-bottom: 10px;
            }

            /* Ensure the mobile-only footer logo is also constrained */
            .footer-logo-section img {
                height: 28px;
                width: auto;
                object-fit: contain;
                margin-bottom: 10px;
                max-width: 80%;
            }

            .footer-brand-name {
                font-size: 18px;
                font-weight: 600;
                color: #fff;
                margin-bottom: 20px;
            }

            .footer-separator {
                width: 100%;            /* line spans edge-to-edge within container */
                max-width: 640px;       /* but don’t get too long on larger phones */
                height: 1px;
                background-color: #444;
                margin: 0 auto 16px auto;
            }

            .footer-social-icons {
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-bottom: 20px;
            }

            .social-icon-box {
                width: 40px;
                height: 40px;
                border: 2px solid #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .social-icon-box:hover {
                background-color: #fff;
                transform: scale(1.1);
            }

            .social-icon-box img {
                width: 20px;
                height: 20px;
                filter: brightness(0) invert(1);
            }

            .social-icon-box:hover img {
                filter: brightness(0) invert(0);
            }

            .footer-funding-text {
                font-size: 12px;
                color: #ccc;
                font-weight: 400;
                line-height: 1.4;
                text-align: center;
            }

            /* Hide desktop-only elements on mobile */
            .footer-top,
            .footer-bottom {
                display: none;
            }
        }

        /* Responsive adjustments (basic) */
        @media (max-width: 768px) {

            /* Center page content to align with header/footer edges */
            main.content-area {
                padding-left: 12px;
                padding-right: 12px;
                box-sizing: border-box;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }

            /* Keep footer tweaks only; do not alter header layout */
            .footer-container {
                text-align: center;
            }

            .mobile-nav ul {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }

            .mobile-nav {
                margin-top: 10px;
            }

            /* Do not stack header-right on mobile; handled in header-specific rules */

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

            .footer-container {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .footer-left,
            .footer-center,
            .footer-right {
                justify-content: center;
            }

            .footer-left {
                flex-direction: column;
                gap: 10px;
            }

            .footer-funding-text {
                font-size: 12px;
            }

            .social-icon-box {
                margin: 0 5px;
                /* Adjust spacing */
            }

        }

        /* Utility: force an element to span the full viewport width even
           when nested inside a centered container. */
        /* Make sections span the full page width without using 100vw
           (avoids scrollbar-width overflow on some browsers). */
        .full-bleed {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
            max-width: none;
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
            /* Avoid 1-2px horizontal overflow on some mobile browsers */
            html, body { overflow-x: hidden; }
            .hero-section-wrapper {
                min-height: 300px;
                padding: 20px;
                /* Apply robust full-bleed breakout on mobile */
                border-radius: 0;
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

            /* Mobile styles for horizontal feature cards */
            .horizontal-feature-card {
                flex: 0 0 280px;
                width: 280px;
            }

            .horizontal-feature-card .card-image {
                height: 180px;
            }

            .horizontal-feature-card .card-content {
                padding: 15px;
            }

            .horizontal-feature-card .card-content h3 {
                font-size: 16px;
            }

            .horizontal-feature-card .card-description {
                font-size: 13px;
            }

            .horizontal-feature-card .card-button {
                padding: 10px;
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

        /* Supported By Logos Section */
        .supported-by-section {
            padding: 60px 0;
            background-color: #ffffff;
            text-align: center;
        }

        .supported-by-section h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 40px;
            font-weight: 600;
        }

        .logos-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 60px;
            max-width: 800px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .logo-item {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .logo-item:hover {
            transform: translateY(-5px);
        }

        .logo-item img {
            max-height: 80px;
            max-width: 150px;
            object-fit: contain;
            filter: grayscale(20%);
            transition: filter 0.3s ease;
        }

        .logo-item:hover img {
            filter: grayscale(0%);
        }

        /* Responsive adjustments for logos section */
        @media (max-width: 768px) {
            .supported-by-section {
                padding: 40px 20px;
            }

            .supported-by-section h2 {
                font-size: 24px;
                margin-bottom: 30px;
            }

            .logos-container {
                gap: 30px;
            }

            .logo-item img {
                max-height: 60px;
                max-width: 120px;
            }
        }

        @media (max-width: 480px) {
            .logos-container {
                gap: 20px;
                flex-direction: column;
            }

            .logo-item img {
                max-height: 50px;
                max-width: 100px;
            }
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

        /* Horizontal Scroll Styles for Other Sections */
        .horizontal-feature-card {
            flex: 0 0 320px;
            width: 320px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .horizontal-feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .horizontal-feature-card .card-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .horizontal-feature-card .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .horizontal-feature-card:hover .card-image img {
            transform: scale(1.05);
        }

        .horizontal-feature-card .placeholder-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .horizontal-feature-card .placeholder-image i {
            font-size: 48px;
        }

        .horizontal-feature-card .card-content {
            padding: 20px;
        }

        .horizontal-feature-card .card-content h3 {
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.3;
        }

        .horizontal-feature-card .card-location {
            margin: 0 0 12px 0;
            color: #7f8c8d;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .horizontal-feature-card .card-description {
            margin: 0 0 15px 0;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.5;
        }

        .horizontal-feature-card .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .horizontal-feature-card .meta-item {
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .horizontal-feature-card .meta-price {
            background: #e8f5e8;
            color: #27ae60;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .horizontal-feature-card .meta-rating {
            background: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .horizontal-feature-card .type-badge {
            background: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .horizontal-feature-card .article-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        .horizontal-feature-card .card-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: inline-block;
            box-sizing: border-box;
        }

        .horizontal-feature-card .card-button:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-1px);
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
        /* Interaction: prevent highlight when mobile sidebar opens */
        @media (max-width: 768px) {
            /* Disable tap highlight and text selection on sidebar + header controls */
            .mobile-nav,
            .mobile-nav a,
            .mobile-nav button,
            .sidebar-overlay,
            .mobile-menu-toggle,
            .mobile-menu-toggle button,
            .header-right .header-auth-button {
                -webkit-tap-highlight-color: transparent; /* iOS Safari */
                tap-highlight-color: transparent; /* Non-standard */
                -webkit-user-select: none;
                user-select: none;
                -webkit-touch-callout: none; /* Prevent callout on long-press */
            }

            /* Explicitly cover header logo and login button */
            .header-logo a,
            .header-logo img,
            .header-container a,
            .header-container button,
            .header-right .header-auth-button,
            .header-right .header-auth-button * {
                -webkit-tap-highlight-color: transparent !important;
                tap-highlight-color: transparent !important;
                -webkit-user-select: none;
                user-select: none;
                -webkit-touch-callout: none;
            }

            /* Remove focus outline/shadow for these controls on mobile */
            .mobile-nav a:focus,
            .mobile-nav button:focus,
            .sidebar-overlay:focus,
            .mobile-menu-toggle:focus,
            .mobile-menu-toggle button:focus,
            .header-right .header-auth-button:focus,
            .header-logo a:focus,
            .header-container a:focus,
            .header-container button:focus {
                outline: none !important;
                box-shadow: none !important;
            }

            /* Also neutralize :active state to avoid momentary highlight */
            .mobile-nav a:active,
            .mobile-nav button:active,
            .mobile-menu-toggle:active,
            .mobile-menu-toggle button:active,
            .header-right .header-auth-button:active,
            .header-logo a:active,
            .header-container a:active,
            .header-container button:active {
                outline: none !important;
                box-shadow: none !important;
                -webkit-tap-highlight-color: transparent !important;
            }

            /* When sidebar is open, ensure nothing inside gets text-selected */
            .mobile-nav.open,
            .mobile-nav.open * {
                -webkit-user-select: none;
                user-select: none;
            }
        }
    </style>

</head>

<body>
    <header>
        <div class="header-container">
            <!-- Mobile Menu Toggle (Mobile Only) -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                &#8801;
            </button>

            <!-- Logo (Centered on Mobile, Left on Desktop) -->
            <a href="/" class="header-logo">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo">
            </a>

            <!-- Desktop Navigation (Desktop Only) -->
            <nav class="desktop-nav">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('about.index') }}">About Us</a></li>
                    <li><a href="/tourist-attractions">Tourist Attractions</a></li>
                    <li><a href="/accommodations">Accommodations</a></li>
                    <li><a href="/products">Products</a></li>
                    <li><a href="{{ route('articles.index')}}">News</a></li>
                    @auth
                    <li><a href="/transactions">Transactions</a></li>
                    @endauth
                </ul>
            </nav>
            
            <!-- Mobile Sidebar Navigation -->
            <nav class="mobile-nav" id="mobileNav">
                <div class="sidebar-header">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="logo">
                    <button class="sidebar-close" onclick="closeMobileMenu()">&times;</button>
                </div>
                <ul>
                    <li><a href="/" onclick="closeMobileMenu()">Home</a></li>
                    <li><a href="{{ route('about.index') }}" onclick="closeMobileMenu()">About Us</a></li>
                    <li><a href="/tourist-attractions" onclick="closeMobileMenu()">Tourist Attractions</a></li>
                    <li><a href="/accommodations" onclick="closeMobileMenu()">Accommodations</a></li>
                    <li><a href="/products" onclick="closeMobileMenu()">Products</a></li>
                    <li><a href="{{ route('articles.index')}}" onclick="closeMobileMenu()">News</a></li>
                    @auth
                    <li><a href="/transactions" onclick="closeMobileMenu()">Transactions</a></li>
                    @endauth
                </ul>
            </nav>

            <!-- Sidebar Overlay -->
            <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileMenu()"></div>
            
            <div class="header-right">
                @auth
                <div class="user-dropdown">
                    <button class="header-auth-button dropdown-toggle" onclick="toggleDropdown()">
                        {{ Auth::user()->username ?: Auth::user()->name }}
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="/login" class="header-auth-button">Login/Register</a>
                @endauth

                <!-- Visit Counter -->
                <div class="visit-counter">
                    <i class="fas fa-eye"></i>
                    <span class="visit-count">{{ $formattedVisits }}</span>
                    <span>visits</span>
                </div>
            </div>
        </div>
    </header>

    <div class="page-content">
        @hasSection('hero_content')
        <div class="hero-section-wrapper full-bleed">
            @yield('hero_content')
        </div>
        @endif

        <main class="content-area">
            @yield('content') {{-- Existing placeholder for main page content --}}
        </main>
    </div>

    <footer>
        <div class="footer-container">
            <!-- Desktop Footer Structure -->
            <!-- Top Section -->
            <div class="footer-top">
                <div class="footer-left-top">
                    <div class="footer-logo">
                        <img src="{{ asset('storage/logo.png') }}" alt="Rumah Literasi Hijau Logo">
                    </div>
                </div>
                <div class="footer-center">
                    <a href="https://rumahliterasihijau.id" class="footer-center-title" target="_blank">Rumah Literasi Hijau</a>
                </div>
                <div class="footer-right-top">
                    <div class="footer-social-icons">
                        <a href="http://wa.me/6281213643354" class="social-icon-box" title="WhatsApp">
                            <img src="{{ asset('images/whatsapp-icon.svg') }}" alt="WhatsApp">
                        </a>
                        <a href="https://www.instagram.com/rumahliterasihijau_id?igsh=MWU4MjlvZDRkcWxvag==" class="social-icon-box" target="_blank" title="Instagram">
                            <img src="{{ asset('images/instagram-icon.svg') }}" alt="Instagram">
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Separator -->
            <div class="footer-separator"></div>
            
            <!-- Bottom Section -->
            <div class="footer-bottom">
                <div class="footer-left">
                    <div class="footer-company-name">Rumah Literasi Hijau</div>
                </div>
                
                <div class="footer-right-bottom">
                    <div class="footer-funding-text">
                        Pendanaan dari HIBAH PHM DIKTI KEMENDIKBUDRISAINTEK 2025
                    </div>
                </div>
            </div>

            <!-- Mobile-only elements (hidden on desktop) -->
            <div class="footer-mobile-only">
                <div class="footer-logo-section">
                    <img src="{{ asset('storage/logo.png') }}" alt="Rumah Literasi Hijau Logo">
                    <div class="footer-brand-name">Rumah Literasi Hijau</div>
                </div>

                <div class="footer-separator"></div>

                <div class="footer-social-icons">
                    <a href="https://www.instagram.com/rumahliterasihijau_id?igsh=MWU4MjlvZDRkcWxvag==" class="social-icon-box" target="_blank" title="Instagram">
                        <img src="{{ asset('images/instagram-icon.svg') }}" alt="Instagram">
                    </a>
                    <a href="http://wa.me/6281213643354" class="social-icon-box" title="WhatsApp">
                        <img src="{{ asset('images/whatsapp-icon.svg') }}" alt="WhatsApp">
                    </a>
                </div>

                <div class="footer-separator"></div>

                <div class="footer-funding-text">
                    Pendanaan dari Hibah PkM<br>DIKTI KEMDIKTISAINTEK 2025
                </div>
            </div>
        </div>
    </footer>


    <script>
        // Mobile sidebar functionality
        function toggleMobileMenu() {
            const nav = document.getElementById('mobileNav');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.querySelector('.mobile-menu-toggle');

            nav.classList.toggle('active');
            overlay.classList.toggle('active');
            toggle.classList.toggle('active');
            
            // Prevent body scroll when sidebar is open
            if (nav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
                document.body.classList.add('menu-open');
            } else {
                document.body.style.overflow = '';
                document.body.classList.remove('menu-open');
            }
        }

        function closeMobileMenu() {
            const nav = document.getElementById('mobileNav');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.querySelector('.mobile-menu-toggle');

            nav.classList.remove('active');
            overlay.classList.remove('active');
            toggle.classList.remove('active');
            document.body.style.overflow = '';
            document.body.classList.remove('menu-open');
        }

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMobileMenu();
            }
        });

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

</html>