<?php
require_once 'includes/db.php';

$message = '';
$complaint_id_generated = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic SPAM prevention using a hidden honeypot field
    if (!empty($_POST['honeypot'])) {
        die("Spam detected.");
    }

    $anonymous = isset($_POST['anonymous_status']) ? 1 : 0;
    
    // Reporter details
    $reporter_name = $anonymous ? 'Anonymous' : escape($_POST['reporter_name']);
    $email = $anonymous ? '' : escape($_POST['email']);
    $phone = $anonymous ? '' : escape($_POST['phone']);

    // Incident details
    $child_age = (int)$_POST['child_age'];
    $gender = escape($_POST['gender']);
    $labour_type = escape($_POST['labour_type']);
    
    // Location
    $state = escape($_POST['state']);
    $city = escape($_POST['city']);
    $address = escape($_POST['address']);
    $latitude = !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null;
    $longitude = !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null;
    
    // Description
    $description = escape($_POST['description']);
    $date_observed = escape($_POST['date_observed']);
    $working_hours = escape($_POST['working_hours']);
    $employer_info = escape($_POST['employer_info']);
    
    // Combine description fields
    $full_description = "Date Observed: $date_observed\nWorking Hours: $working_hours\nEmployer Info: $employer_info\nDetails: $description";

    // AI Risk Classification (Simulated)
    $risk_level = 'Low Risk';
    if ($child_age < 14 && in_array($labour_type, ['Factory Work', 'Construction Work', 'Other'])) {
        $risk_level = 'High Risk';
    } elseif ($child_age < 14 || in_array($labour_type, ['Domestic Work', 'Hotel/Restaurant Work'])) {
        $risk_level = 'Medium Risk';
    }

    // Handle File Upload
    $image_path = null;
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $filename = $_FILES['evidence']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed) && $_FILES['evidence']['size'] < 5000000) { // 5MB limit
            $new_filename = uniqid('ev_') . '.' . $file_ext;
            $upload_dir = 'uploads/';
            if (move_uploaded_file($_FILES['evidence']['tmp_name'], $upload_dir . $new_filename)) {
                $image_path = $upload_dir . $new_filename;
            }
        }
    }

    // Generate Unique Complaint ID: CLS + YYYYMMDD + Random 3 digits
    $complaint_id = 'CLS' . date('Ymd') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO complaints (complaint_id, reporter_name, email, phone, anonymous_status, child_age, gender, labour_type, state, city, address, latitude, longitude, description, image, risk_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssissssssddsss", $complaint_id, $reporter_name, $email, $phone, $anonymous, $child_age, $gender, $labour_type, $state, $city, $address, $latitude, $longitude, $full_description, $image_path, $risk_level);

    if ($stmt->execute()) {
        // Add to history
        $history_stmt = $conn->prepare("INSERT INTO status_history (complaint_id, status, remark) VALUES (?, 'Pending', 'Complaint registered successfully.')");
        $history_stmt->bind_param("s", $complaint_id);
        $history_stmt->execute();
        
        $complaint_id_generated = $complaint_id;
        $message = "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm'>
            <p class='font-bold'>Success! Your complaint has been successfully registered.</p>
            <p>Your Complaint ID is: <strong class='text-xl'>$complaint_id</strong></p>
            <p class='text-sm mt-2'>Please save this ID to track the status of your report.</p>
            <div class='mt-4'><a href='track.php?id=$complaint_id' class='bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition'>Track Status</a></div>
        </div>";
        
        // Mock email notification logging (simulating email sent to user)
        if (!$anonymous && !empty($email)) {
            $log = date('Y-m-d H:i:s') . " - Email sent to $email for Complaint $complaint_id\n";
            file_put_contents('email_log.txt', $log, FILE_APPEND);
        }
    } else {
        $message = "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm'>Error submitting report. Please try again.</div>";
    }
}

include 'includes/header.php';
?>

<div class="bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                Report Child Labour Anonymously
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Your identity will remain completely confidential. You can submit information without revealing any personal details to help protect a child in need.
            </p>
        </div>

        <?php echo $message; ?>

        <?php if (empty($complaint_id_generated)): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <form action="report.php" method="POST" enctype="multipart/form-data" class="p-8">
                
                <!-- Honeypot -->
                <input type="text" name="honeypot" style="display:none">

                <!-- Section 1: Reporter Info -->
                <div class="mb-10">
                    <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-primary"></i> Reporter Information (Optional)
                        </h2>
                        <div class="flex items-center">
                            <input id="anonymous_status" name="anonymous_status" type="checkbox" class="h-5 w-5 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                            <label for="anonymous_status" class="ml-2 block text-sm font-bold text-danger cursor-pointer">
                                Submit Report Anonymously
                            </label>
                        </div>
                    </div>
                    
                    <div id="reporter_info_section" class="grid grid-cols-1 md:grid-cols-2 gap-6 transition-opacity duration-300">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <input type="text" name="reporter_name" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                            <input type="tel" name="phone" class="form-input">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                            <input type="email" name="email" class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Incident Details -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-accent"></i> Incident Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Child's Approximate Age <span class="text-danger">*</span></label>
                            <input type="number" name="child_age" required min="4" max="18" class="form-input" placeholder="e.g. 10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender <span class="text-danger">*</span></label>
                            <select name="gender" required class="form-select">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other / Not Sure</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type of Labour <span class="text-danger">*</span></label>
                            <select name="labour_type" required class="form-select">
                                <option value="">Select Type</option>
                                <option value="Factory Work">Factory Work</option>
                                <option value="Construction Work">Construction Work</option>
                                <option value="Hotel/Restaurant Work">Hotel/Restaurant Work</option>
                                <option value="Domestic Work">Domestic Work</option>
                                <option value="Street Work">Street Work</option>
                                <option value="Agricultural Work">Agricultural Work</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Observed <span class="text-danger">*</span></label>
                            <input type="date" name="date_observed" required class="form-input">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Working Hours</label>
                            <input type="text" name="working_hours" class="form-input" placeholder="e.g. 8 AM to 8 PM">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employer Information</label>
                            <input type="text" name="employer_info" class="form-input" placeholder="Name or Shop Name">
                        </div>
                        
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description of Incident <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" required class="form-textarea" placeholder="Provide specific details of what you observed..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Location -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-secondary"></i> Location Details
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" required class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" required class="form-input">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Address / Landmark <span class="text-danger">*</span></label>
                            <textarea name="address" rows="2" required class="form-textarea" placeholder="Exact street address or nearby landmark..."></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pinpoint on Map (Optional but helpful)</label>
                        <div id="location_map" class="w-full h-64 bg-gray-200 rounded-md border border-gray-300 z-10"></div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-hand-pointer"></i> Click on the map to set location marker.</p>
                    </div>
                </div>

                <!-- Section 4: Evidence -->
                <div class="mb-10">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-camera text-gray-500"></i> Evidence Upload
                    </h2>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600 hover:border-primary transition cursor-pointer" onclick="document.getElementById('evidence_upload').click()">
                        <div class="space-y-1 text-center">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-2"></i>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                <label for="evidence_upload" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="evidence_upload" name="evidence" type="file" class="sr-only" accept="image/jpeg,image/png,application/pdf">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 5MB</p>
                            <p id="file_name_display" class="text-sm font-bold text-secondary mt-2"></p>
                        </div>
                    </div>
                </div>

                <!-- CAPTCHA Simulation -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600 flex items-center gap-3">
                    <input type="checkbox" required class="h-6 w-6 text-primary rounded cursor-pointer" id="human_check">
                    <label for="human_check" class="text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer">I verify that the information provided is true to my knowledge and I am human.</label>
                </div>

                <div class="pt-5 text-center md:text-right">
                    <button type="submit" class="inline-flex justify-center py-3 px-8 border border-transparent shadow-md text-base font-medium rounded-md text-white bg-danger hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all w-full md:w-auto">
                        Submit Complaint Securely <i class="fa-solid fa-paper-plane ml-2 mt-1"></i>
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // File upload display name
    document.getElementById('evidence_upload')?.addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            document.getElementById('file_name_display').innerText = "Selected: " + e.target.files[0].name;
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
