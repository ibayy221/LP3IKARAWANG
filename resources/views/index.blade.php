@php
    // Normalize variables so the template is safe whether controller
    // provides Blade $carouselData or legacy $carousel.
    $carouselData = isset($carouselData) ? $carouselData : (isset($carousel) ? $carousel : []);
    $newsData = isset($newsData) ? $newsData : [];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LP3I Karawang - Politeknik LP3I Kampus Karawang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header */
        header {
            background: rgba(30, 60, 114, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header.scrolled {
            background: rgba(30, 60, 114, 0.95);
            backdrop-filter: blur(30px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            height: 50px;
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 100%;
            width: auto;
            max-width: 200px;
            object-fit: contain;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0;
            align-items: center;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.6rem 1.2rem; /* Adjusted padding */
            display: block;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-radius: 0;
            font-size: 0.95rem;
            font-weight: 500;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            /* background: rgba(255, 255, 255, 0.05); */ /* Removed for mobile */
            border: none;
            /* backdrop-filter: blur(10px); */ /* Removed for mobile */
        }

        /* .nav-links a::before { */ /* Removed for mobile */
        /*     content: ''; */
        /*     position: absolute; */
        /*     top: 0; */
        /*     left: -100%; */
        /*     width: 100%; */
        /*     height: 100%; */
        /*     background: linear-gradient(90deg, transparent, rgba(74, 144, 226, 0.3), transparent); */
        /*     transition: left 0.5s; */
        /* } */

        .nav-links a:hover::before {
            left: 100%;
        }

        .nav-links a:hover {
            /* background: rgba(74, 144, 226, 0.2); */
            /* color: #74b9ff; */
            /* transform: none; */
            box-shadow: none;
        }
        /* Mobile specific adjustments for nav-links a */
        @media (max-width: 768px) {
            .nav-links a {
                width: 100%;
                padding: 0.8rem 2rem; /* Adjusted padding for better mobile touch targets */
                text-align: left;
                background: transparent; /* Ensure no background on mobile */
                backdrop-filter: none; /* Ensure no backdrop-filter on mobile */
            }
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute;
            top: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            min-width: 220px;
            border-radius: 12px;
            z-index: 1000;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateX(-50%) translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            transform: translateX(-50%) translateY(0) scale(1);
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            .dropdown-content {
                width: 100%;
                position: static; /* Override absolute positioning for mobile */
                transform: none; /* Remove transform for mobile */
                opacity: 1; /* Always visible when active on mobile */
                border-radius: 0; /* No border-radius for flush look */
                box-shadow: none; /* No shadow for mobile */
                margin-left: 0; /* Remove left margin */
                min-width: auto; /* Remove min-width constraint */
                background: rgba(255,255,255,0.05); /* Slightly different background for sub-items */
                border-top: 1px solid rgba(255, 255, 255, 0.1); /* Separator for dropdowns */
                display: none; /* Hide by default on mobile, will be toggled by JS */
            }

            .dropdown-content.active {
                display: block; /* Show when active on mobile */
            }
        }

        /* .dropdown:hover .dropdown-content { */ /* Moved to desktop-only styles */
        /*     display: block; */
        /*     opacity: 1; */
        /*     transform: translateX(-50%) translateY(0) scale(1); */
        /* } */

        .dropdown-content a {
            color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px; /* Adjusted padding */
            text-decoration: none;
            display: block;
            transition: all 0.3s;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            background: transparent;
            border: none;
        }

        /* .dropdown-content a::before { */ /* Removed for mobile */
        /*     content: ''; */
        /*     position: absolute; */
        /*     left: 0; */
        /*     top: 0; */
        /*     width: 0; */
        /*     height: 100%; */
        /*     background: linear-gradient(90deg, rgba(74, 144, 226, 0.3), rgba(74, 144, 226, 0.1)); */
        /*     transition: width 0.3s ease; */
        /* } */

        .dropdown-content a:hover::before {
            width: 100%;
        }

        .dropdown-content a:hover {
            color: rgba(255, 255, 255, 0.9); /* Keep original color */
            background: transparent; /* Ensure no background on hover */
            transform: none; /* Ensure no transform on hover */
        }
        /* Mobile specific adjustments for dropdown-content a */
        @media (max-width: 768px) {
            .dropdown-content a {
                padding: 0.6rem 2.5rem; /* Indent dropdown items, adjusted padding */
                color: rgba(255, 255, 255, 0.8);
                background: transparent;
                transform: none; /* Remove transform on hover for mobile */
            }
            .dropdown-content a:hover {
                background: transparent; /* Ensure no background on hover for mobile */
                color: rgba(255, 255, 255, 0.8); /* Keep original color for mobile */
                transform: none; /* Ensure no transform on hover for mobile */
            }
        }

        .dropdown > a::after {
            content: ' ▼';
            font-size: 0.7rem;
            margin-left: 3px;
            transition: transform 0.3s;
        }

        .dropdown:hover > a::after {
            transform: rotate(180deg);
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .carousel-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

/* Per-slide backgrounds are applied inline on each .carousel-slide element
   to avoid embedding Blade/PHP directives inside the <style> block, which
   can confuse CSS parsers and editors. */

        .carousel-content {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
            text-align: center;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .indicator {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(116, 185, 255, 0.8), transparent);
            transition: left 0.6s ease;
        }

        .indicator:hover::before {
            left: 100%;
        }

        .indicator.active {
            background: #74b9ff;
            box-shadow: 0 0 15px rgba(116, 185, 255, 0.6);
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 3;
            backdrop-filter: blur(10px);
            border-radius: 50%;
        }

        .carousel-nav:hover {
            background: rgba(74, 144, 226, 0.5);
        }

        .carousel-nav.prev {
            left: 30px;
        }

        .carousel-nav.next {
            right: 30px;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.8);
            animation: slideInUp 1s ease-out;
        }

        .hero-content p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.8);
            line-height: 1.6;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 0.8rem 2rem;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            animation: slideInUp 1s ease-out 0.4s both;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }


        /* News Section */
        .news {
            padding: 5rem 2rem;
            background: #f8f9fa;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .news-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            opacity: 0;
            transform: translateY(50px);
            animation-fill-mode: both;
        }

        .news-card.animate {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .news-card.animate:nth-child(1) {
            animation-delay: 0.1s;
        }

        .news-card.animate:nth-child(2) {
            animation-delay: 0.3s;
        }

        .news-card.animate:nth-child(3) {
            animation-delay: 0.5s;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        /* Section title animation */
        .section-title {
            opacity: 0;
            transform: translateY(30px);
            animation-fill-mode: both;
        }

        .section-title.animate {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-category {
            display: inline-block;
            background: #4a90e2;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .news-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #1e3c72;
            line-height: 1.4;
        }

        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .news-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }

        .news-date {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .news-author {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .view-all-news {
            text-align: center;
            margin-top: 3rem;
        }

        .view-all-news .btn {
            display: inline-block;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 0.8rem 2rem;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }

        .view-all-news .btn:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }

        /* Registration Button Styling */
        .register-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 0.5rem;
            background: #004269 !important;
            color: white !important;
            padding: 0.9rem 1.8rem !important;
            text-decoration: none !important;
            border-radius: 30px !important;
            font-weight: 700 !important;
            font-size: 1.05rem !important;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 6px 20px rgba(0, 66, 105, 0.3) !important;
            border: none !important;
            cursor: pointer !important;
            animation: registerPulse 2s ease-in-out infinite;
        }

        .register-btn:hover {
            background: #003352 !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 66, 105, 0.5) !important;
            animation: none;
        }

        @keyframes registerPulse {
            0%, 100% {
                box-shadow: 0 6px 20px rgba(0, 66, 105, 0.3);
            }
            50% {
                box-shadow: 0 8px 30px rgba(0, 66, 105, 0.6);
            }
        }

        /* CTA Registration Banner */
        .registration-banner {
            background: linear-gradient(135deg, #004269, #003352);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
            margin: 3rem 0;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 66, 105, 0.2);
        }

        .registration-banner h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .registration-banner p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        @media (max-width: 768px) {
            .registration-banner {
                padding: 2rem 1rem;
            }
            .registration-banner h3 {
                font-size: 1.5rem;
            }
            .registration-banner p {
                font-size: 0.95rem;
            }
        }

        /* Programs Section */
        .programs {
            padding: 5rem 2rem;
            background: white;
        }

        .program-card {
            opacity: 0;
            transform: translateY(50px);
            animation-fill-mode: both;
        }

        .program-card.animate {
            animation: slideInUp 0.8s ease-out forwards;
        }

        .program-card.animate:nth-child(1) {
            animation-delay: 0.1s;
        }

        .program-card.animate:nth-child(2) {
            animation-delay: 0.3s;
        }

        .program-card.animate:nth-child(3) {
            animation-delay: 0.5s;
        }

        .program-card.animate:nth-child(4) {
            animation-delay: 0.7s;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1e3c72;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .programs-grid .program-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .programs-grid .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .program-icon {
            font-size: 3rem;
            color: #2a5298;
            margin-bottom: 1rem;
        }

        .program-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1e3c72;
        }

        /* About Section */
        .about {
            padding: 5rem 2rem;
            background: white;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #1e3c72;
        }

        .about-text p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #666;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2a5298;
        }

        .stat-label {
            color: #666;
            margin-top: 0.5rem;
        }

        /* Footer */
        footer {
            background: #1e3c72;
            color: white;
            padding: 3rem 2rem 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #ffd700;
        }

        .footer-section p, .footer-section a {
            color: #ccc;
            text-decoration: none;
            margin-bottom: 0.5rem;
            display: block;
        }

        .footer-section a:hover {
            color: #ffd700;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #2a5298;
            color: #ccc;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            nav {
                max-width: 100%;
                padding: 0 1rem;
            }
            
            .nav-links a {
                padding: 0.8rem 0.7rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #1e3c72;
                flex-direction: column;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }

            .nav-links.active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .dropdown-content {
                position: static;
                display: none; /* Hidden by default on mobile */
                box-shadow: none;
                background: rgba(255,255,255,0.05); /* Slightly different background for sub-items */
                margin-left: 0; /* Remove left margin */
                width: 100%; /* Ensure full width */
                border-radius: 0; /* No border-radius for flush look */
                border: none; /* Remove border */
                backdrop-filter: none; /* Remove backdrop-filter */
            }

            .dropdown-content a {
                color: #ccc;
                padding: 0.8rem 2.5rem; /* Adjust padding for better touch targets and indentation */
            }

            .hero-content h1 {
                font-size: 1.6rem;
            }

            .hero-content p {
                font-size: 0.9rem;
            }

            .about-content {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            /* Mobile News Section */
            .news {
                padding: 3rem 1rem;
            }

            .news-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Two columns for mobile */
                gap: 1rem; /* Adjust gap for two columns */
                margin-top: 2rem;
            }


            .news-content {
                padding: 1rem; /* Adjusted padding */
            }

            .news-card h3 {
                font-size: 0.9rem; /* Slightly smaller font for two columns */
                margin-bottom: 0.4rem;
                line-height: 1.2;
            }

            .news-excerpt {
                font-size: 0.75rem; /* Slightly smaller font for two columns */
                line-height: 1.3;
                margin-bottom: 0.6rem;
            }

            .news-category {
                font-size: 0.65rem; /* Slightly smaller font for two columns */
                padding: 0.15rem 0.5rem;
                margin-bottom: 0.6rem;
            }

            .news-meta {
                font-size: 0.65rem; /* Slightly smaller font for two columns */
                flex-direction: column;
                align-items: flex-start;
                gap: 0.2rem;
                padding-top: 0.6rem;
            }

            .news-image {
                height: 100px; /* Adjust image height for two columns */
            }

            .section-title {
                font-size: 1.6rem;
                margin-bottom: 1.5rem;
            }

            .view-all-news {
                margin-top: 1.5rem;
            }

            .view-all-news .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .news {
                padding: 2rem 0.75rem;
            }

            .news-grid {
                gap: 0.75rem; /* Further reduce gap for very small screens */
            }

            .news-content {
                padding: 0.6rem; /* Further adjust padding for very small screens */
            }

            .news-card h3 {
                font-size: 0.8rem; /* Further adjust font size for very small screens */
                line-height: 1.1;
            }

            .news-excerpt {
                font-size: 0.7rem; /* Further adjust font size for very small screens */
                line-height: 1.2;
            }

            .news-category {
                font-size: 0.6rem; /* Further adjust font size for very small screens */
                padding: 0.1rem 0.4rem;
            }

            .news-meta {
                font-size: 0.6rem; /* Further adjust font size for very small screens */
            }

            .news-image {
                height: 80px; /* Further reduce image height for very small screens */
            }

            .section-title {
                font-size: 1.4rem;
                margin-bottom: 1.2rem;
            }

            .carousel-nav {
                display: none;
            }

            .hero-content h1 {
                font-size: 1.4rem;
            }

            .hero-content p {
                font-size: 0.8rem;
            }

            .cta-button {
                padding: 0.6rem 1.5rem;
                font-size: 0.8rem;
            }

            .view-all-news .btn {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <img src="{{ asset('storage/logo/lp3i-logo.png') }}" alt="LP3I Karawang Logo" />
            </div>
            <button class="mobile-menu-toggle">☰</button>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li class="dropdown">
                    <a href="#profil">Profil</a>
                    <div class="dropdown-content">
                        <a href="#sejarah">Sejarah</a>
                        <a href="#visi-misi">Visi & Misi</a>
                        <a href="#struktur">Struktur Organisasi</a>
                        <a href="#fasilitas">Fasilitas</a>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#programs">Program Studi</a>
                    <div class="dropdown-content">
                        <a href="#teknik-informatika">Teknik Informatika</a>
                        <a href="#manajemen-bisnis">Manajemen Bisnis</a>
                        <a href="#akuntansi">Akuntansi</a>
                        <a href="#marketing-digital">Marketing Digital</a>
                    </div>
                </li>

                <li class="dropdown">
                    <!-- Link langsung ke form pendaftaran mahasiswa -->
                    <a href="{{ route('mahasiswa.create') }}">Pendaftaran</a>
                    <div class="dropdown-content">
                        <!-- Form pendaftaran (mahasiswa.create) -->
                        <a href="{{ route('mahasiswa.create') }}">Form Pendaftaran</a>
                        <!-- Jika diperlukan, tambahkan tautan lain yang relevan di sini -->
                    </div>
                </li>


                <li class="dropdown">
                    <a href="#akademik">Akademik</a>
                    <div class="dropdown-content">
                        <a href="#kalender-akademik">Kalender Akademik</a>
                        <a href="#kurikulum">Kurikulum</a>
                        <a href="#sistem-pembelajaran">Sistem Pembelajaran</a>
                        <a href="#evaluasi">Evaluasi</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#dosen">Dosen</a>
                    <div class="dropdown-content">
                        <a href="#profil-dosen">Profil Dosen</a>
                        <a href="#penelitian">Penelitian</a>
                        <a href="#publikasi">Publikasi</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#pusat-karir">Pusat Karir</a>
                    <div class="dropdown-content">
                        <a href="#lowongan-kerja">Lowongan Kerja</a>
                        <a href="#magang">Program Magang</a>
                        <a href="#alumni">Alumni</a>
                        <a href="#kerjasama-industri">Kerjasama Industri</a>
                    </div>
                </li>
                <li><a href="#ormawa">Ormawa</a></li>
                <li><a href="#kegiatan">Kegiatan</a></li>
                <li><a href="#pendaftaran" class="register-btn"><i class="fas fa-clipboard-check"></i> Daftar Sekarang</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="carousel-container">
            @foreach($carouselData as $index => $slide)
                @php
                    $slideNum = $index + 1;
                    $imagePath = !empty($slide['image']) ? $slide['image'] : '';
                @endphp

                @php
                    // Normalize slide image path: try public path first, then storage (public disk)
                    $slideImageUrl = null;
                    if (!empty($imagePath) && file_exists(public_path($imagePath))) {
                        $slideImageUrl = asset($imagePath);
                    } elseif (!empty($imagePath) && file_exists(public_path('storage/' . ltrim($imagePath, '/')))) {
                        $slideImageUrl = asset('storage/' . ltrim($imagePath, '/'));
                    } elseif (!empty($imagePath) && file_exists(storage_path('app/public/' . ltrim($imagePath, '/')))) {
                        // If the file exists in storage/app/public, ensure it will be served from public/storage
                        $slideImageUrl = asset('storage/' . ltrim($imagePath, '/'));
                    }
                @endphp
                @if(!empty($slideImageUrl))
                    <div class="carousel-slide slide-{{ $slideNum }} {{ $index === 0 ? 'active' : '' }}" style="background: url('{{ $slideImageUrl }}'); background-size: cover; background-position: center;">
                    </div>
                @else
                    @php
                        $gradients = [
                            "linear-gradient(rgba(30, 60, 114, 0.8), rgba(42, 82, 152, 0.8)), url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 600\"><rect fill=\"%23f0f8ff\" width=\"1200\" height=\"600\"/><circle fill=\"%23e6f3ff\" cx=\"200\" cy=\"150\" r=\"80\"/><circle fill=\"%23d9edff\" cx=\"800\" cy=\"400\" r=\"120\"/><circle fill=\"%23cce7ff\" cx=\"1000\" cy=\"200\" r=\"60\"/></svg>')",
                            "linear-gradient(rgba(42, 82, 152, 0.8), rgba(30, 60, 114, 0.8)), url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 600\"><rect fill=\"%23e8f4fd\" width=\"1200\" height=\"600\"/><polygon fill=\"%23d1e7fc\" points=\"0,0 400,200 0,400\"/><polygon fill=\"%23b8d9fb\" points=\"800,0 1200,0 1200,300\"/><circle fill=\"%239fc9f9\" cx=\"600\" cy=\"300\" r=\"100\"/></svg>')",
                            "linear-gradient(rgba(74, 144, 226, 0.8), rgba(30, 60, 114, 0.8)), url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1200 600\"><rect fill=\"%23f5f9ff\" width=\"1200\" height=\"600\"/><rect fill=\"%23e1f0ff\" x=\"100\" y=\"100\" width=\"200\" height=\"150\" rx=\"20\"/><rect fill=\"%23cce7ff\" x=\"900\" y=\"350\" width=\"250\" height=\"180\" rx=\"25\"/><circle fill=\"%23b3ddff\" cx=\"500\" cy=\"400\" r=\"90\"/></svg>')"
                        ];
                        $gradientIndex = $index % count($gradients);
                    @endphp
                    <div class="carousel-slide slide-{{ $slideNum }} {{ $index === 0 ? 'active' : '' }}" style="background: {!! $gradients[$gradientIndex] !!}; background-size: cover; background-position: center;">
                    </div>
                @endif
            @endforeach
        </div>

        <button class="carousel-nav prev">‹</button>
        <button class="carousel-nav next">›</button>

        @php
            // Decide what to show in the hero content. We always render the
            // slide backgrounds, but if the first slide lacks human-friendly
            // title/subtitle/button, show the default hero copy on top of the
            // background so the page doesn't display the raw filename.
            $firstSlide = (!empty($carouselData) && isset($carouselData[0])) ? $carouselData[0] : null;
            $hasReadableContent = false;
            if ($firstSlide) {
                $t = trim((string)($firstSlide['title'] ?? ''));
                $s = trim((string)($firstSlide['subtitle'] ?? ''));
                $b = trim((string)($firstSlide['button'] ?? ''));

                $looksLikeFilename = false;
                if ($t !== '') {
                    if (stripos($t, 'screenshot') !== false) {
                        $looksLikeFilename = true;
                    }
                    if (preg_match('/\d{4,}/', $t) && strpos($t, ' ') === false) {
                        $looksLikeFilename = true;
                    }
                    if (preg_match('/^[A-Za-z0-9_\-]+$/', $t) && preg_match('/\d/', $t) && strpos($t, ' ') === false) {
                        $looksLikeFilename = true;
                    }
                }

                if (($t !== '' && !$looksLikeFilename) || $s !== '' || $b !== '') {
                    $hasReadableContent = true;
                }
            }
        @endphp

        <div class="carousel-content">
            <div class="hero-content" id="slide-content">
                @if($hasReadableContent)
                    <h1>{{ $firstSlide['title'] ?? '' }}</h1>
                    <p>{{ $firstSlide['subtitle'] ?? '' }}</p>
                    <a href="{{ route('mahasiswa.create') }}" class="cta-button">{{ !empty($firstSlide['button']) ? $firstSlide['button'] : 'DAFTAR' }}</a>
                @else
                    <h1>Kembangkan Karirmu bersama LP3I Karawang</h1>
                    <p>Praktik nyata. Kurikulum up-to-date. Lulusan siap kerja.</p>
                    <a href="{{ route('mahasiswa.create') }}" class="cta-button">Daftar Sekarang</a>
                @endif
            </div>
        </div>
        
        <div class="carousel-indicators">
            @foreach($carouselData as $index => $slide)
                <div class="indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
            @endforeach
        </div>
    </section>

    <!-- Registration CTA Banner -->
    <section class="registration-banner" id="pendaftaran">
        <h3><i class="fas fa-graduation-cap"></i> Bergabunglah dengan LP3I Karawang</h3>
        <p>Raih masa depan cerah bersama program studi unggulan kami. Daftar sekarang dan dapatkan kesempatan untuk berkembang dengan kurikulum terdepan dan fasilitas modern.</p>
        <a href="#" onclick="alert('Halaman pendaftaran akan segera diluncurkan. Hubungi kami di (0267) 123-4567 untuk informasi lebih lanjut.'); return false;" class="register-btn">
            <i class="fas fa-sign-in-alt"></i> Daftar Online Sekarang
        </a>
    </section>

    <!-- News Section -->
    <section class="news" id="news">
        <div class="container">
            <h2 class="section-title">Berita Terbaru</h2>
            
            @if(empty($newsData))
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <i class="fas fa-newspaper" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <h3>Belum Ada Berita</h3>
                    <p>Berita terbaru akan ditampilkan di sini.</p>
                </div>
            @else
                <div class="news-grid">
                    @foreach($newsData as $news)
                        <div class="news-card" onclick="location.href='news.php?id={{ $news['id'] }}'" style="cursor: pointer;">
                                            @php
                                                $newsImage = null;
                                                if (!empty($news['image_path']) && file_exists(public_path($news['image_path']))) {
                                                    $newsImage = asset($news['image_path']);
                                                } elseif (!empty($news['image_path']) && file_exists(public_path('storage/' . ltrim($news['image_path'], '/')))) {
                                                    $newsImage = asset('storage/' . ltrim($news['image_path'], '/'));
                                                } elseif (!empty($news['image_path']) && file_exists(storage_path('app/public/' . ltrim($news['image_path'], '/')))) {
                                                    $newsImage = asset('storage/' . ltrim($news['image_path'], '/'));
                                                }
                                            @endphp
                                            @if($newsImage)
                                                <img src="{{ $newsImage }}" alt="{{ $news['title'] }}" class="news-image">
                            @else
                                <div class="news-image" style="display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            
                            <div class="news-content">
                                <span class="news-category">{{ $news['category'] }}</span>
                                <h3>{{ $news['title'] }}</h3>
                                <p class="news-excerpt">
                                    {{ $news['excerpt'] ?: (strlen($news['content']) > 150 ? substr($news['content'], 0, 150) . '...' : $news['content']) }}
                                </p>
                                <div class="news-meta">
                                    <div class="news-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ date('d M Y', strtotime($news['created_at'])) }}
                                    </div>
                                    <div class="news-author">
                                        <i class="fas fa-user"></i>
                                        {{ $news['author'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="view-all-news">
                    <a href="news.php" class="btn">Lihat Semua Berita</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs" id="programs">
        <div class="container">
            <h2 class="section-title">Program Studi Unggulan</h2>
            <div class="programs-grid">
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Teknik Informatika</h3>
                    <p>Program studi yang mempersiapkan mahasiswa menjadi programmer dan developer handal dengan kurikulum yang selalu update mengikuti perkembangan teknologi.</p>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Manajemen Bisnis</h3>
                    <p>Membekali mahasiswa dengan kemampuan manajemen modern dan kewirausahaan untuk menghadapi tantangan dunia bisnis yang dinamis.</p>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>Akuntansi</h3>
                    <p>Program studi yang menghasilkan tenaga ahli akuntansi yang kompeten dan siap kerja di berbagai sektor industri dan pemerintahan.</p>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Marketing Digital</h3>
                    <p>Menyiapkan mahasiswa menjadi ahli pemasaran digital yang mampu memanfaatkan teknologi untuk strategi pemasaran modern.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang LP3I Karawang</h2>
                    <p>Politeknik LP3I Kampus Karawang adalah institusi pendidikan vokasi yang berkomitmen menghasilkan lulusan berkualitas dan siap kerja. Dengan pengalaman puluhan tahun, kami terus berinovasi dalam memberikan pendidikan terbaik.</p>
                    <p>Kampus kami dilengkapi dengan fasilitas modern dan tenaga pengajar yang berpengalaman di bidangnya masing-masing. Kami menjalin kerjasama dengan berbagai industri untuk memastikan lulusan kami dapat langsung berkarya di dunia kerja.</p>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">25+</div>
                        <div class="stat-label">Tahun Pengalaman</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5000+</div>
                        <div class="stat-label">Alumni Sukses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Tingkat Kelulusan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Mitra Industri</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <p><i class="fas fa-map-marker-alt"></i> Jl. Raya Karawang, Karawang Barat, Kabupaten Karawang, Jawa Barat</p>
                <p><i class="fas fa-phone"></i> (0267) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@lp3ikarawang.ac.id</p>
            </div>
            <div class="footer-section">
                <h3>Program Studi</h3>
                <a href="#">Teknik Informatika</a>
                <a href="#">Manajemen Bisnis</a>
                <a href="#">Akuntansi</a>
                <a href="#">Marketing Digital</a>
            </div>
            <div class="footer-section">
                <h3>Layanan</h3>
                <a href="#">Pendaftaran Online</a>
                <a href="#">Beasiswa</a>
                <a href="#">Karir Center</a>
                <a href="#">Alumni Network</a>
            </div>
            <div class="footer-section">
                <h3>Ikuti Kami</h3>
                <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
                <a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Politeknik LP3I Kampus Karawang. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
            // Close all dropdowns when main menu is toggled
            document.querySelectorAll('.dropdown-content').forEach(content => {
                content.classList.remove('active');
            });
        });

        // Mobile dropdown toggle
        document.querySelectorAll('.nav-links .dropdown > a').forEach(dropdownToggle => {
            dropdownToggle.addEventListener('click', function(e) {
                // Only apply this behavior on mobile
                if (window.innerWidth <= 768) {
                    e.preventDefault(); // Prevent default link behavior
                    const dropdownContent = this.nextElementSibling;
                    if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
                        // Close other open dropdowns
                        document.querySelectorAll('.dropdown-content.active').forEach(openDropdown => {
                            if (openDropdown !== dropdownContent) {
                                openDropdown.classList.remove('active');
                            }
                        });
                        dropdownContent.classList.toggle('active');
                    }
                }
            });
        });

        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.indicator');
        const slideContent = document.getElementById('slide-content');
        
        // Touch/Swipe support for mobile
        let startX = 0;
        let endX = 0;
        let isTouch = false;
        
    // Slide data generated from server-side carouselData
    const slideData = @json($carouselData);
    // URL to redirect when CTA is clicked (Mahasiswa create)
    const MAHASISWA_CREATE_URL = "{{ route('mahasiswa.create') }}";

        function updateSlideContent(index) {
            if (slideData.length === 0) return;

            const data = slideData[index % slideData.length];

            // Determine if the slide has human-friendly content. If the
            // title contains letters (not just numbers) or subtitle/button is
            // present, we'll replace the hero content. Otherwise leave the
            // default slogan in place so filenames or numeric titles aren't
            // shown to users.
            const hasReadableTitle = typeof data.title === 'string' && /[A-Za-z\p{L}]/u.test(data.title);
            const hasSubtitle = typeof data.subtitle === 'string' && data.subtitle.trim() !== '';
            const hasButton = typeof data.button === 'string' && data.button.trim() !== '';

            if (hasReadableTitle || hasSubtitle || hasButton) {
                slideContent.innerHTML = `
                    <h1>${data.title}</h1>
                    <p>${data.subtitle}</p>
                    <a href="${MAHASISWA_CREATE_URL}" class="cta-button">${data.button || 'DAFTAR'}</a>
                `;
            }
            // otherwise keep the existing hero content (slogan/default)
        }

        function showSlide(index) {
            if (slideData.length === 0) return;
            
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));
            
            const slideIndex = index % slideData.length;
            const indicatorIndex = index % indicators.length;
            
            slides[slideIndex % slides.length].classList.add('active');
            indicators[indicatorIndex].classList.add('active');
            updateSlideContent(slideIndex);
            currentSlide = index;
        }

        function nextSlide() {
            if (slideData.length === 0) return;
            currentSlide = (currentSlide + 1) % slideData.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            if (slideData.length === 0) return;
            currentSlide = (currentSlide - 1 + slideData.length) % slideData.length;
            showSlide(currentSlide);
        }

        // Auto-slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Navigation controls
        document.querySelector('.carousel-nav.next').addEventListener('click', nextSlide);
        document.querySelector('.carousel-nav.prev').addEventListener('click', prevSlide);

        // Indicator controls
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        // Touch/Swipe event handlers
        const heroSection = document.querySelector('.hero');
        
        heroSection.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isTouch = true;
        });
        
        heroSection.addEventListener('touchmove', (e) => {
            if (!isTouch) return;
            e.preventDefault();
        });
        
        heroSection.addEventListener('touchend', (e) => {
            if (!isTouch) return;
            endX = e.changedTouches[0].clientX;
            handleSwipe();
            isTouch = false;
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - next slide
                    nextSlide();
                } else {
                    // Swipe right - previous slide
                    prevSlide();
                }
            }
        }

        // Initialize carousel with PHP data
        updateSlideContent(0);
        showSlide(0);

        // Scroll animation for news section
        function animateOnScroll() {
            const elements = document.querySelectorAll('.news-card, .section-title, .program-card');
            
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animate');
                }
            });
        }

        // Initial check for elements already in view
        animateOnScroll();

        // Listen for scroll events
        window.addEventListener('scroll', animateOnScroll);

        // Add stagger animation for news cards
        function staggerNewsCards() {
            const newsCards = document.querySelectorAll('.news-card');
            newsCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
            });
        }

        // Initialize stagger animation
        staggerNewsCards();
    </script>
</body>
</html>