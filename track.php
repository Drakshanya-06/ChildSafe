<?php
require_once 'includes/db.php';

$complaint = null;
$history = [];
$error = '';
$search_id = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $search_id = escape($_GET['id']);
    
    // Fetch complaint
    $stmt = $conn->prepare("SELECT * FROM complaints WHERE complaint_id = ?");
    $stmt->bind_param("s", $search_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $complaint = $result->fetch_assoc();
        
        // Fetch history
        $h_stmt = $conn->prepare("SELECT * FROM status_history WHERE complaint_id = ? ORDER BY updated_at ASC");
        $h_stmt->bind_param("s", $search_id);
        $h_stmt->execute();
        $h_result = $h_stmt->get_result();
        while($row = $h_result->fetch_assoc()) {
            $history[] = $row;
        }
    } else {
        $error = "No complaint found with ID: $search_id";
    }
}

include 'includes/header.php';
?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                Track Complaint Status
            </h1>
            <p class="mt-4 text-gray-600 dark:text-gray-400">
                Enter your unique Complaint ID to check the current status and updates regarding your report.
            </p>
        </div>

        <!-- Search Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 border border-gray-100 dark:border-gray-700">
            <form action="track.php" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-grow">
                    <label for="id" class="sr-only">Complaint ID</label>
                    <input type="text" name="id" id="id" value="<?php echo $search_id; ?>" required class="form-input text-lg py-3" placeholder="Enter Complaint ID (e.g. CLS20260709001)">
                </div>
                <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-md transition shadow flex items-center justify-center whitespace-nowrap">
                    Track Status <i class="fa-solid fa-magnifying-glass ml-2"></i>
                </button>
            </form>
            <?php if ($error): ?>
                <p class="mt-4 text-danger font-medium text-center"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo $error; ?></p>
            <?php endif; ?>
        </div>

        <?php if ($complaint): ?>
        <!-- Complaint Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 mb-8 animate-fade-in">
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">Report Details</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ID: <?php echo $complaint['complaint_id']; ?></p>
                </div>
                
                <?php 
                    $status_colors = [
                        'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'Under Review' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'Investigation Started' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'Rescue Completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'Closed' => 'bg-gray-100 text-gray-800 border-gray-200',
                        'Rejected' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $badge_class = $status_colors[$complaint['status']] ?? 'bg-gray-100 text-gray-800';
                ?>
                <span class="px-4 py-1.5 rounded-full text-sm font-bold border <?php echo $badge_class; ?>">
                    <?php echo $complaint['status']; ?>
                </span>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Date Reported</p>
                    <p class="text-gray-900 dark:text-white font-medium"><?php echo date('d M Y, h:i A', strtotime($complaint['created_at'])); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Location</p>
                    <p class="text-gray-900 dark:text-white font-medium"><?php echo $complaint['city'] . ', ' . $complaint['state']; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Labour Type</p>
                    <p class="text-gray-900 dark:text-white font-medium"><?php echo $complaint['labour_type']; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Latest Admin Remark</p>
                    <p class="text-gray-900 dark:text-white font-medium"><?php echo $complaint['admin_remark'] ? $complaint['admin_remark'] : 'None yet'; ?></p>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Status Timeline</h3>
        <div class="relative pl-8 border-l-2 border-gray-200 dark:border-gray-700 space-y-8 animate-fade-in delay-100">
            <?php foreach($history as $index => $item): ?>
                <?php 
                    $is_last = ($index === count($history) - 1);
                    $icon_color = $is_last ? 'bg-primary border-4 border-blue-100 dark:border-blue-900' : 'bg-gray-400 border-4 border-white dark:border-gray-800';
                ?>
                <div class="relative">
                    <div class="absolute -left-[41px] w-5 h-5 rounded-full <?php echo $icon_color; ?>"></div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm border border-gray-100 dark:border-gray-700 <?php echo $is_last ? 'ring-1 ring-primary' : ''; ?>">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg"><?php echo $item['status']; ?></h4>
                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                <?php echo date('d M Y, H:i', strtotime($item['updated_at'])); ?>
                            </span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            <?php echo $item['remark'] ? $item['remark'] : 'Status updated.'; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
