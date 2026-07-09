<?php
require_once 'includes/db.php';

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['volunteer_submit'])) {
    $name = escape($_POST['name']);
    $email = escape($_POST['email']);
    $interest = escape($_POST['interest']);
    
    $stmt = $conn->prepare("INSERT INTO volunteers (name, email, interest) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $interest);
    
    if ($stmt->execute()) {
        $msg = "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded'>Thank you! Your volunteer application has been submitted successfully.</div>";
    } else {
        $msg = "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded'>Error submitting application.</div>";
    }
}

include 'includes/header.php';
?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                Our NGO Network & Partners
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                We collaborate with verified, dedicated organizations across the country to rescue, rehabilitate, and educate children.
            </p>
        </div>

        <!-- NGO Partners Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            <!-- NGO 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 p-6 hover-card">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 text-primary rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-hands-holding-child"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Child Welfare Foundation</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4"><i class="fa-solid fa-location-dot mr-1"></i> New Delhi, India</p>
                <div class="mb-4">
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Rescue Operations</span>
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Legal Aid</span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700 pt-4 mt-auto">
                    <p><i class="fa-solid fa-phone mr-2 text-primary"></i> +91 98765 43210</p>
                    <p class="mt-1"><i class="fa-solid fa-envelope mr-2 text-primary"></i> contact@cwf.org</p>
                </div>
            </div>

            <!-- NGO 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 p-6 hover-card">
                <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900 text-accent rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Education Support Group</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4"><i class="fa-solid fa-location-dot mr-1"></i> Mumbai, Maharashtra</p>
                <div class="mb-4">
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Free Education</span>
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Counseling</span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700 pt-4 mt-auto">
                    <p><i class="fa-solid fa-phone mr-2 text-accent"></i> +91 91234 56789</p>
                    <p class="mt-1"><i class="fa-solid fa-envelope mr-2 text-accent"></i> help@esg.org</p>
                </div>
            </div>

            <!-- NGO 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 p-6 hover-card">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 text-danger rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-kit-medical"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hope Rescue Team</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4"><i class="fa-solid fa-location-dot mr-1"></i> Bangalore, Karnataka</p>
                <div class="mb-4">
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Medical Care</span>
                    <span class="inline-block bg-gray-100 dark:bg-gray-700 text-xs px-2 py-1 rounded text-gray-600 dark:text-gray-300 mr-2 mb-2">Shelter Homes</span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-700 pt-4 mt-auto">
                    <p><i class="fa-solid fa-phone mr-2 text-danger"></i> +91 99887 76655</p>
                    <p class="mt-1"><i class="fa-solid fa-envelope mr-2 text-danger"></i> rescue@hope.org</p>
                </div>
            </div>
        </div>

        <!-- Volunteer Section -->
        <div id="volunteer" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row">
            <div class="md:w-5/12 bg-primary text-white p-10 flex flex-col justify-center">
                <h2 class="text-3xl font-bold mb-4">Become a Volunteer</h2>
                <p class="text-blue-100 mb-6">Join our network of passionate individuals. Contribute your time and skills to help eradicate child labour and build a safer future.</p>
                <ul class="space-y-4">
                    <li class="flex items-center"><i class="fa-solid fa-check-circle mr-3 text-secondary"></i> Assist in awareness campaigns</li>
                    <li class="flex items-center"><i class="fa-solid fa-check-circle mr-3 text-secondary"></i> Provide basic education</li>
                    <li class="flex items-center"><i class="fa-solid fa-check-circle mr-3 text-secondary"></i> Help in data collection</li>
                    <li class="flex items-center"><i class="fa-solid fa-check-circle mr-3 text-secondary"></i> Offer technical or legal skills</li>
                </ul>
            </div>
            <div class="md:w-7/12 p-10">
                <?php echo $msg; ?>
                <form action="ngo.php#volunteer" method="POST">
                    <input type="hidden" name="volunteer_submit" value="1">
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                        <input type="text" name="name" required class="form-input">
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                        <input type="email" name="email" required class="form-input">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Area of Interest / Skills</label>
                        <select name="interest" required class="form-select">
                            <option value="">Select an option</option>
                            <option value="Education/Teaching">Education/Teaching</option>
                            <option value="Awareness Campaigns">Awareness Campaigns</option>
                            <option value="Legal Assistance">Legal Assistance</option>
                            <option value="Field Work/Rescue">Field Work/Rescue</option>
                            <option value="IT/Tech Support">IT/Tech Support</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-secondary hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded transition">
                        Submit Application
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
