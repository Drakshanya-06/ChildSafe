<?php
require_once 'includes/db.php';

$error = '';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = escape($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_user'] = $username;
            header("Location: admin/dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}

// Don't include standard header for admin login to keep it distinct and secure-looking
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - ChildSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { primary: '#b1d3b9', secondary: '#f59e0b', danger: '#ef4444' },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #b1d3b9 0%, #e0ece3 100%);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 flex h-screen overflow-hidden">
    
    <!-- Left Side: Branding (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
        
        <div class="relative z-10 text-center px-12">
            <i class="fa-solid fa-hands-holding-child text-white text-8xl mb-8 drop-shadow-lg"></i>
            <h1 class="text-5xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">ChildSafe</h1>
            <p class="text-xl text-white font-medium opacity-90 drop-shadow">Admin Portal & Management System</p>
            <p class="mt-8 text-white opacity-75 text-sm max-w-md mx-auto">Authorized access only. By logging in, you agree to uphold our privacy standards and protect sensitive data.</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-24 bg-white relative">
        <a href="index.php" class="absolute top-8 right-8 text-sm text-gray-500 hover:text-gray-900 transition flex items-center gap-2">
            <i class="fa-solid fa-house"></i> Public Site
        </a>

        <div class="w-full max-w-md">
            <div class="lg:hidden text-center mb-8">
                <i class="fa-solid fa-hands-holding-child text-primary text-5xl mb-4"></i>
                <h1 class="text-3xl font-extrabold text-gray-900">ChildSafe Admin</h1>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
            <p class="text-gray-500 mb-8">Please sign in to your administrator account.</p>

            <?php if($error): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm text-sm flex items-center">
                    <i class="fa-solid fa-triangle-exclamation mr-3 text-lg"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="admin_login.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address or Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <input type="text" name="username" required class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm" placeholder="admin@example.com">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" name="password" required class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm" placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-gray-800 bg-primary hover:bg-[#9ebc9e] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all mt-6">
                    Sign In
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </form>
            
            <div class="mt-8 text-center bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-600 shadow-inner">
                <span class="block font-semibold mb-1 text-gray-700">Testing Credentials</span>
                Username: <code class="bg-gray-200 px-1.5 py-0.5 rounded text-gray-800">admin</code><br>
                Password: <code class="bg-gray-200 px-1.5 py-0.5 rounded text-gray-800">password123</code>
            </div>
        </div>
    </div>
</body>
</html>
