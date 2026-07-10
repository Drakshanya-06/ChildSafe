<?php
require_once '../includes/db.php';

// Check authentication
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

// Fetch basic stats
$stats = [
    'total' => $conn->query("SELECT COUNT(*) FROM complaints")->fetch_row()[0],
    'pending' => $conn->query("SELECT COUNT(*) FROM complaints WHERE status = 'Pending'")->fetch_row()[0],
    'verified' => $conn->query("SELECT COUNT(*) FROM complaints WHERE status = 'Under Review' OR status = 'Investigation Started'")->fetch_row()[0],
    'resolved' => $conn->query("SELECT COUNT(*) FROM complaints WHERE status = 'Rescue Completed' OR status = 'Closed'")->fetch_row()[0],
];

// Fetch data for charts
// 1. Labour Type Distribution
$labour_data = [];
$res = $conn->query("SELECT labour_type, COUNT(*) as count FROM complaints GROUP BY labour_type");
while($row = $res->fetch_assoc()) {
    $labour_data['labels'][] = $row['labour_type'];
    $labour_data['data'][] = $row['count'];
}

// 2. Risk Level Distribution
$risk_data = [];
$res = $conn->query("SELECT risk_level, COUNT(*) as count FROM complaints GROUP BY risk_level");
while($row = $res->fetch_assoc()) {
    $risk_data['labels'][] = $row['risk_level'];
    $risk_data['data'][] = $row['count'];
}

// Fetch recent complaints for table
$recent_complaints = $conn->query("SELECT * FROM complaints ORDER BY created_at DESC LIMIT 5");

// Fetch points for Map
$map_points = [];
$res = $conn->query("SELECT latitude, longitude, complaint_id, risk_level, labour_type FROM complaints WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
while($row = $res->fetch_assoc()) {
    $map_points[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ChildSafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { primary: '#1d4ed8', secondary: '#f59e0b', danger: '#ef4444' } }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <div class="p-6 border-b border-gray-800 flex items-center gap-3">
                <i class="fa-solid fa-hands-holding-child text-primary text-3xl"></i>
                <span class="text-xl font-bold">Admin Portal</span>
            </div>
            <nav class="flex-1 py-4">
                <a href="dashboard.php" class="flex items-center px-6 py-3 bg-gray-800 text-white border-l-4 border-primary">
                    <i class="fa-solid fa-chart-line w-6"></i> Dashboard
                </a>
                <a href="complaints.php" class="flex items-center px-6 py-3 text-gray-400 hover:bg-gray-800 hover:text-white transition border-l-4 border-transparent hover:border-gray-500">
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
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center font-bold">
                        <?php echo strtoupper(substr($_SESSION['admin_user'], 0, 1)); ?>
                    </div>
                    <div>
                        <p class="font-bold text-sm"><?php echo htmlspecialchars($_SESSION['admin_user']); ?></p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <a href="logout.php" class="block w-full text-center py-2 bg-red-600 hover:bg-red-700 rounded text-sm font-bold transition">Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <!-- Header (Mobile mostly) -->
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center md:hidden">
                <div class="font-bold text-xl text-primary"><i class="fa-solid fa-hands-holding-child"></i> ChildSafe</div>
                <a href="logout.php" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i></a>
            </header>

            <div class="p-6 md:p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                    <div class="flex gap-2">
                        <a href="complaints.php" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md shadow-sm hover:bg-gray-50 text-sm font-medium transition"><i class="fa-solid fa-eye mr-2"></i>View All</a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Complaints</p>
                                <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['total']; ?></h3>
                            </div>
                            <div class="p-2 bg-blue-100 text-blue-600 rounded"><i class="fa-solid fa-file-lines"></i></div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Pending Review</p>
                                <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['pending']; ?></h3>
                            </div>
                            <div class="p-2 bg-yellow-100 text-yellow-600 rounded"><i class="fa-solid fa-hourglass-half"></i></div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Under Action</p>
                                <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['verified']; ?></h3>
                            </div>
                            <div class="p-2 bg-purple-100 text-purple-600 rounded"><i class="fa-solid fa-shield-halved"></i></div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Resolved Cases</p>
                                <h3 class="text-3xl font-bold text-gray-800"><?php echo $stats['resolved']; ?></h3>
                            </div>
                            <div class="p-2 bg-green-100 text-green-600 rounded"><i class="fa-solid fa-check-circle"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Chart 1 -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Labour Type Distribution</h3>
                        <div class="h-64">
                            <canvas id="labourChart"></canvas>
                        </div>
                    </div>
                    <!-- Chart 2 -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Risk Level Analysis</h3>
                        <div class="h-64">
                            <canvas id="riskChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Map Row -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Complaint Heatmap / Location View</h3>
                    <div id="admin_map" class="h-96 w-full rounded-md border border-gray-300 z-0"></div>
                </div>

                <!-- Recent Table -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Recent Complaints</h3>
                        <a href="complaints.php" class="text-primary text-sm hover:underline font-medium">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID & Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk Level</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while($row = $recent_complaints->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900"><?php echo $row['complaint_id']; ?></div>
                                        <div class="text-sm text-gray-500"><?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo htmlspecialchars($row['city']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($row['state']); ?></div>
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
                                        <a href="view_complaint.php?id=<?php echo $row['id']; ?>" class="text-primary hover:text-blue-900 bg-blue-50 px-3 py-1 rounded">View</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if($recent_complaints->num_rows == 0): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No complaints found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Charts Script -->
    <script>
        // Labour Chart
        const labourCtx = document.getElementById('labourChart').getContext('2d');
        new Chart(labourCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labour_data['labels'] ?? []); ?>,
                datasets: [{
                    data: <?php echo json_encode($labour_data['data'] ?? []); ?>,
                    backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6', '#64748b']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Risk Chart
        const riskCtx = document.getElementById('riskChart').getContext('2d');
        new Chart(riskCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($risk_data['labels'] ?? []); ?>,
                datasets: [{
                    label: 'Number of Cases',
                    data: <?php echo json_encode($risk_data['data'] ?? []); ?>,
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',  // High Risk - Red
                        'rgba(245, 158, 11, 0.7)', // Medium Risk - Amber
                        'rgba(59, 130, 246, 0.7)'  // Low Risk - Blue
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(245, 158, 11)',
                        'rgb(59, 130, 246)'
                    ],
                    borderWidth: 1
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        // Leaflet Map Initialization
        const mapData = <?php echo json_encode($map_points); ?>;
        if (mapData.length > 0) {
            // Default center based on first point
            const map = L.map('admin_map').setView([mapData[0].latitude, mapData[0].longitude], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            mapData.forEach(point => {
                let color = point.risk_level === 'High Risk' ? 'red' : (point.risk_level === 'Medium Risk' ? 'orange' : 'blue');
                
                // Custom icon simulation (using basic circles for heatmap effect)
                L.circleMarker([point.latitude, point.longitude], {
                    radius: 8,
                    fillColor: color,
                    color: '#fff',
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map)
                .bindPopup(`<b>ID:</b> ${point.complaint_id}<br><b>Risk:</b> ${point.risk_level}<br><b>Type:</b> ${point.labour_type}`);
            });
        } else {
            document.getElementById('admin_map').innerHTML = '<div class="flex items-center justify-center h-full text-gray-500">No location data available yet.</div>';
        }
    </script>
</body>
</html>
