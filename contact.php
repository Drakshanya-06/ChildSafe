<?php 
require_once 'includes/db.php';

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit'])) {
    // In a real application, this would save to a DB or send an email.
    // For this demonstration, we'll just show a success message.
    $name = escape($_POST['name']);
    $email = escape($_POST['email']);
    
    $msg = "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded'>
        <strong>Thank you, $name!</strong> Your message has been received. Our team will contact you at $email shortly.
    </div>";
}

include 'includes/header.php'; 
?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16 animate-fade-in">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Contact Us</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Have questions about our platform, want to partner with us, or need technical support? We'd love to hear from you.
            </p>
            <p class="mt-2 text-sm text-danger font-semibold">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> Do NOT use this form to report child labour. <a href="report.php" class="underline">Click here to report an incident.</a>
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700 max-w-5xl mx-auto animate-fade-in delay-100">
            <div class="flex flex-col md:flex-row">
                
                <!-- Contact Information (Left Col) -->
                <div class="md:w-5/12 bg-gray-900 text-white p-10 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-6 text-white">Get in Touch</h2>
                        <p class="text-gray-400 mb-10 text-sm leading-relaxed">
                            Fill out the form and our team will get back to you within 24 hours. For emergencies, please use the national helpline.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <i class="fa-solid fa-location-dot mt-1 text-primary text-xl w-8"></i>
                                <div>
                                    <p class="font-semibold">Headquarters</p>
                                    <p class="text-gray-400 text-sm">123 Impact Avenue, Sector 4<br>New Delhi, India 110001</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fa-solid fa-phone text-primary text-xl w-8"></i>
                                <div>
                                    <p class="font-semibold">General Inquiries</p>
                                    <p class="text-gray-400 text-sm">+91 11 2345 6789</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fa-solid fa-envelope text-primary text-xl w-8"></i>
                                <div>
                                    <p class="font-semibold">Email Us</p>
                                    <p class="text-gray-400 text-sm">contact@childsafe-app.org</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-12 pt-8 border-t border-gray-800">
                        <p class="font-semibold mb-4 text-sm">Follow our initiative:</p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form (Right Col) -->
                <div class="md:w-7/12 p-10 md:p-12">
                    <?php echo $msg; ?>
                    <form action="contact.php" method="POST">
                        <input type="hidden" name="contact_submit" value="1">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">First Name</label>
                                <input type="text" name="name" required class="form-input">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Name</label>
                                <input type="text" name="last_name" class="form-input">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <input type="email" name="email" required class="form-input">
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                            <select name="subject" class="form-select">
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="NGO Partnership">NGO Partnership</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Press/Media">Press/Media</option>
                            </select>
                        </div>
                        
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                            <textarea name="message" rows="4" required class="form-textarea" placeholder="How can we help you?"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow-md transition flex justify-center items-center">
                            Send Message <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
