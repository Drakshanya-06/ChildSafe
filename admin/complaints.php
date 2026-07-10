<?php
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

$status_filter = isset($_GET['status']) ? escape($_GET['status']) : '';
$query = "SELECT * FROM complaints";
if ($status_filter) {
    $query .= " WHERE status = '$status_filter'";
}
$query .= " ORDER BY created_at DESC";

$complaints = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints - ChildSafe Admin</title>
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
                <a href="complaints.php" class="flex items-center px-6 py-3 bg-gray-800 text-white border-l-4 border-blue-600">
                    <i class="fa-solid fa-table-list w-6"></i> All Complaints
                </a>
                <a href="volunteers.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
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
                <h1 class="text-2xl font-bold text-gray-800">Manage Complaints</h1>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-200 flex gap-4 overflow-x-auto">
                <a href="complaints.php" class="px-4 py-2 rounded-md text-sm font-medium <?php echo $status_filter == '' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">All</a>
                <a href="complaints.php?status=Pending" class="px-4 py-2 rounded-md text-sm font-medium <?php echo $status_filter == 'Pending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">Pending</a>
                <a href="complaints.php?status=Under Review" class="px-4 py-2 rounded-md text-sm font-medium <?php echo $status_filter == 'Under Review' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">Under Review</a>
                <a href="complaints.php?status=Investigation Started" class="px-4 py-2 rounded-md text-sm font-medium <?php echo $status_filter == 'Investigation Started' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">Investigation</a>
                <a href="complaints.php?status=Rescue Completed" class="px-4 py-2 rounded-md text-sm font-medium <?php echo $status_filter == 'Rescue Completed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">Rescued</a>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complaint ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date / Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Labour Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while($row = $complaints->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    <?php echo $row['complaint_id']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($row['city'] . ', ' . $row['state']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $row['labour_type']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $risk_color = 'bg-gray-100 text-gray-800';
                                        if($row['risk_level'] == 'High Risk') $risk_color = 'bg-red-100 text-red-800';
                                        if($row['risk_level'] == 'Medium Risk') $risk_color = 'bg-orange-100 text-orange-800';
                                        if($row['risk_level'] == 'Low Risk') $risk_color = 'bg-blue-100 text-blue-800';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $risk_color; ?>">
                                        <?php echo $row['risk_level']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?php echo $row['status']; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="view_complaint.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition border border-blue-200"><i class="fa-solid fa-folder-open mr-1"></i> Open</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if($complaints->num_rows == 0): ?>
                            <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500">No complaints found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
