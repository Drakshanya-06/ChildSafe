<?php
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id_to_delete = (int)$_GET['delete'];
    $del_stmt = $conn->prepare("DELETE FROM volunteers WHERE id = ?");
    $del_stmt->bind_param("i", $id_to_delete);
    $del_stmt->execute();
    header("Location: volunteers.php?msg=deleted");
    exit();
}

$volunteers = $conn->query("SELECT * FROM volunteers ORDER BY created_at DESC");
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Volunteers - ChildSafe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-hands-holding-child text-[#b1d3b9] text-3xl"></i>
                <span class="text-xl font-bold">Admin Portal</span>
            </div>
            <nav class="flex-1 py-4">
                <a href="dashboard.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
                    <i class="fa-solid fa-chart-line w-6"></i> Dashboard
                </a>
                <a href="complaints.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
                    <i class="fa-solid fa-table-list w-6"></i> All Complaints
                </a>
                <a href="volunteers.php" class="flex items-center px-6 py-3 bg-gray-800 text-white border-l-4 border-[#b1d3b9]">
                    <i class="fa-solid fa-users w-6"></i> Volunteers
                </a>
                <a href="manage_admins.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
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
                <h1 class="text-2xl font-bold text-gray-800">Manage Volunteers</h1>
            </div>

            <?php if ($msg == 'deleted'): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p>Volunteer record has been successfully deleted.</p>
            </div>
            <?php endif; ?>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area of Interest</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Registered</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while($row = $volunteers->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-[#b1d3b9] hover:underline"><?php echo htmlspecialchars($row['email']); ?></a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['interest']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="volunteers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this volunteer?');" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition border border-red-200"><i class="fa-solid fa-trash mr-1"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if($volunteers->num_rows == 0): ?>
                            <tr><td colspan="5" class="px-6 py-10 text-center text-gray-500">No volunteers found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
