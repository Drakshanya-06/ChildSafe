<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChildSafe - Child Labour Reporting System</title>
    <meta name="description" content="Report child labour anonymously. A social impact platform to help protect children and track complaints.">
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#b1d3b9', // pastel-green
                        secondary: '#f59e0b', // amber-500
                        accent: '#10b981', // emerald-500
                        danger: '#ef4444', // red-500
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body class="font-sans bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center gap-2">
                        <i class="fa-solid fa-hands-holding-child text-primary text-3xl"></i>
                        <span class="font-bold text-2xl tracking-tight text-primary">ChildSafe</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">Home</a>
                    <a href="about.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">About Us</a>
                    <a href="awareness.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">Awareness</a>
                    <a href="reviews.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">Reviews</a>
                    <a href="ngo.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">NGO Network</a>
                    <a href="contact.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">Contact</a>
                    <a href="track.php" class="text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition">Track Status</a>
                    <a href="report.php" class="bg-danger text-white px-4 py-2 rounded-md font-medium hover:bg-red-600 transition shadow-sm">Report Case <i class="fa-solid fa-bullhorn ml-1"></i></a>
                    
                    <!-- Language Dropdown (Simulated) -->
                    <select id="language-select" class="bg-gray-100 dark:bg-gray-700 border-none rounded-md text-sm py-1 focus:ring-0 cursor-pointer">
                        <option value="en">English</option>
                        <option value="hi">Hindi</option>
                        <option value="te">Telugu</option>
                    </select>

                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                        <i id="theme-toggle-dark-icon" class="hidden fa-solid fa-moon"></i>
                        <i id="theme-toggle-light-icon" class="hidden fa-solid fa-sun"></i>
                    </button>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Home</a>
                <a href="about.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">About Us</a>
                <a href="awareness.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Awareness</a>
                <a href="reviews.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Reviews</a>
                <a href="ngo.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">NGO Network</a>
                <a href="contact.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Contact</a>
                <a href="track.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Track Status</a>
                <a href="report.php" class="block px-3 py-2 rounded-md text-base font-medium bg-danger text-white text-center mt-4">Report Case</a>
            </div>
        </div>
    </nav>
    <main class="min-h-[calc(100vh-64px-300px)]">
