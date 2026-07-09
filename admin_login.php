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
                    colors: { primary: '#1d4ed8', secondary: '#f59e0b', danger: '#ef4444' }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 h-screen flex items-center justify-center font-sans transition-colors duration-300">
    
    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <a href="index.php" class="inline-flex items-center gap-2 mb-2">
                <i class="fa-solid fa-hands-holding-child text-primary text-4xl"></i>
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Admin Portal</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Secure access for authorized personnel only.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
            <?php if($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 rounded text-sm">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="admin_login.php" method="POST">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input type="text" name="username" required class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 border">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" name="password" required class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2 border">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                    Sign In <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                </button>
            </form>
            
            <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                Default credentials for testing:<br>
                Username: <b>admin</b> | Password: <b>password123</b>
            </div>
        </div>
        <div class="text-center mt-6">
            <a href="index.php" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-blue-400"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Public Site</a>
        </div>
    </div>
</body>
</html>
