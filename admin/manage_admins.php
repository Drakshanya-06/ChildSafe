<?php
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

$msg = '';
$error = '';

// Handle Add Admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $new_username = escape($_POST['username']);
    $new_password = $_POST['password'];

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $hashed_pw = password_hash($new_password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $new_username, $hashed_pw);
        if ($insert->execute()) {
            $msg = "New administrator added successfully.";
        } else {
            $error = "Failed to add administrator.";
        }
    }
}

// Handle Delete Admin
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_to_delete = (int)$_GET['delete'];
    
    // Prevent self-deletion
    if ($id_to_delete == $_SESSION['admin_id']) {
        $error = "You cannot delete your own admin account!";
    } else {
        $del_stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        $del_stmt->bind_param("i", $id_to_delete);
        if ($del_stmt->execute()) {
            $msg = "Administrator account deleted.";
        } else {
            $error = "Failed to delete account.";
        }
    }
}

$admins = $conn->query("SELECT id, username, created_at FROM admins ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - ChildSafe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-hands-holding-child text-blue-600 text-3xl"></i>
                <span class="text-xl font-bold">Admin Portal</span>
            </div>
            <nav class="flex-1 py-4">
                <a href="dashboard.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
                    <i class="fa-solid fa-chart-line w-6"></i> Dashboard
                </a>
                <a href="complaints.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
                    <i class="fa-solid fa-table-list w-6"></i> All Complaints
                </a>
                <a href="volunteers.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
                    <i class="fa-solid fa-users w-6"></i> Volunteers
                </a>
                <a href="manage_admins.php" class="flex items-center px-6 py-3 bg-gray-800 text-white border-l-4 border-blue-600">
                    <i class="fa-solid fa-user-shield w-6"></i> Manage Admins
                </a>
            </nav>
            <div class="p-4 border-t border-gray-800">
                <a href="logout.php" class="block w-full text-center py-2 bg-red-600 hover:bg-red-700 rounded text-sm font-bold transition">Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-6 md:p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Manage Administrators</h1>
            </div>

            <?php if ($msg): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p><?php echo htmlspecialchars($msg); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Add New Admin Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-user-plus text-blue-500 mr-2"></i>Add New Admin</h2>
                        <form action="manage_admins.php" method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                                <input type="text" name="username" required class="w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" required class="w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">Create Administrator</button>
                        </form>
                    </div>
                </div>

                <!-- List of Admins -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">Current Administrators</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php while($row = $admins->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            #<?php echo $row['id']; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            <?php echo htmlspecialchars($row['username']); ?>
                                            <?php if ($row['id'] == $_SESSION['admin_id']): ?>
                                                <span class="ml-2 px-2 py-0.5 rounded text-xs bg-green-100 text-green-800 font-bold border border-green-200">YOU</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <?php if ($row['id'] != $_SESSION['admin_id']): ?>
                                                <a href="manage_admins.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('WARNING: Are you sure you want to revoke admin access for <?php echo addslashes($row['username']); ?>?');" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition border border-red-200"><i class="fa-solid fa-user-xmark mr-1"></i> Revoke Access</a>
                                            <?php else: ?>
                                                <span class="text-gray-400 italic">Cannot delete self</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
