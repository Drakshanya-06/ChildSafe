<?php
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM complaints WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Complaint not found.");
}

$complaint = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details - ChildSafe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
                <a href="complaints.php" class="flex items-center px-6 py-3 bg-gray-800 text-white border-l-4 border-[#b1d3b9]">
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
            
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <a href="complaints.php" class="text-gray-500 hover:text-[#b1d3b9] mb-2 inline-block"><i class="fa-solid fa-arrow-left mr-1"></i> Back to Complaints</a>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                        Complaint #<?php echo $complaint['complaint_id']; ?>
                        <span class="text-sm font-normal px-3 py-1 bg-gray-200 text-gray-700 rounded-full border border-gray-300"><?php echo $complaint['status']; ?></span>
                    </h1>
                </div>
                <button onclick="window.print()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded shadow-sm hover:bg-gray-50 text-sm font-medium"><i class="fa-solid fa-print mr-2"></i>Print/Export</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Col (Details) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Incident Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-circle-info text-blue-500 mr-2"></i>Incident Details</h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div><p class="text-xs text-gray-500 font-bold uppercase">Child Age</p><p class="text-gray-900"><?php echo $complaint['child_age']; ?> years</p></div>
                            <div><p class="text-xs text-gray-500 font-bold uppercase">Gender</p><p class="text-gray-900"><?php echo $complaint['gender']; ?></p></div>
                            <div><p class="text-xs text-gray-500 font-bold uppercase">Labour Type</p><p class="text-gray-900"><?php echo $complaint['labour_type']; ?></p></div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Risk Assessment</p>
                                <p class="<?php echo $complaint['risk_level'] == 'High Risk' ? 'text-red-600 font-bold' : ($complaint['risk_level'] == 'Medium Risk' ? 'text-orange-500 font-bold' : 'text-[#b1d3b9] font-bold'); ?>">
                                    <?php echo $complaint['risk_level']; ?>
                                </p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Full Description</p>
                            <div class="bg-gray-50 p-4 rounded border border-gray-200 text-gray-800 whitespace-pre-line text-sm"><?php echo htmlspecialchars($complaint['description']); ?></div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-location-dot text-red-500 mr-2"></i>Location Information</h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div><p class="text-xs text-gray-500 font-bold uppercase">State</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['state']); ?></p></div>
                            <div><p class="text-xs text-gray-500 font-bold uppercase">City</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['city']); ?></p></div>
                            <div class="col-span-2"><p class="text-xs text-gray-500 font-bold uppercase">Full Address</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['address']); ?></p></div>
                        </div>
                        <?php if($complaint['latitude'] && $complaint['longitude']): ?>
                        <div id="complaint_map" class="h-64 w-full rounded border border-gray-300"></div>
                        <script>
                            var map = L.map('complaint_map').setView([<?php echo $complaint['latitude']; ?>, <?php echo $complaint['longitude']; ?>], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                            L.marker([<?php echo $complaint['latitude']; ?>, <?php echo $complaint['longitude']; ?>]).addTo(map);
                        </script>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Evidence -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-camera text-gray-500 mr-2"></i>Evidence</h2>
                        <?php if($complaint['image']): ?>
                            <?php 
                                $ext = strtolower(pathinfo($complaint['image'], PATHINFO_EXTENSION)); 
                                if($ext == 'pdf'):
                            ?>
                                <a href="../<?php echo $complaint['image']; ?>" target="_blank" class="inline-block bg-blue-50 text-blue-700 px-4 py-2 rounded border border-blue-200"><i class="fa-solid fa-file-pdf mr-2"></i>View PDF Document</a>
                            <?php else: ?>
                                <img src="../<?php echo $complaint['image']; ?>" class="max-w-full h-auto rounded border border-gray-200" alt="Evidence">
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-gray-500 italic">No evidence files attached.</p>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Right Col (Action & Reporter Info) -->
                <div class="space-y-6">
                    
                    <!-- Update Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-pen-to-square text-green-500 mr-2"></i>Update Status</h2>
                        <form action="update_status.php" method="POST">
                            <input type="hidden" name="complaint_id" value="<?php echo $complaint['complaint_id']; ?>">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
                                <select name="status" class="w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-[#b1d3b9] focus:border-[#b1d3b9]">
                                    <option value="Pending" <?php if($complaint['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Under Review" <?php if($complaint['status']=='Under Review') echo 'selected'; ?>>Under Review</option>
                                    <option value="Investigation Started" <?php if($complaint['status']=='Investigation Started') echo 'selected'; ?>>Investigation Started</option>
                                    <option value="Rescue Completed" <?php if($complaint['status']=='Rescue Completed') echo 'selected'; ?>>Rescue Completed</option>
                                    <option value="Closed" <?php if($complaint['status']=='Closed') echo 'selected'; ?>>Closed</option>
                                    <option value="Rejected" <?php if($complaint['status']=='Rejected') echo 'selected'; ?>>Rejected (Fake Report)</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Remark</label>
                                <textarea name="remark" rows="3" class="w-full rounded border-gray-300 shadow-sm p-2 border focus:ring-[#b1d3b9] focus:border-[#b1d3b9]" placeholder="Add notes (visible to user)..."><?php echo htmlspecialchars($complaint['admin_remark'] ?? ''); ?></textarea>
                            </div>
                            <button type="submit" class="w-full bg-[#b1d3b9] text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">Update Record</button>
                        </form>
                    </div>

                    <!-- Reporter Info -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-user-shield text-purple-500 mr-2"></i>Reporter Details</h2>
                        <?php if($complaint['anonymous_status']): ?>
                            <div class="bg-gray-100 text-gray-600 p-4 rounded text-center border border-gray-200">
                                <i class="fa-solid fa-user-secret text-3xl mb-2"></i>
                                <p class="font-bold text-sm uppercase">Anonymous Report</p>
                                <p class="text-xs mt-1">Identity was not provided.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-3">
                                <div><p class="text-xs text-gray-500 font-bold uppercase">Name</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['reporter_name']); ?></p></div>
                                <div><p class="text-xs text-gray-500 font-bold uppercase">Phone</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['phone']); ?></p></div>
                                <div><p class="text-xs text-gray-500 font-bold uppercase">Email</p><p class="text-gray-900"><?php echo htmlspecialchars($complaint['email']); ?></p></div>
                            </div>
                        <?php endif; ?>
                        <div class="mt-4 pt-4 border-t text-xs text-gray-400">
                            Reported on: <?php echo date('Y-m-d H:i:s', strtotime($complaint['created_at'])); ?>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</body>
</html>
