    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-hands-holding-child text-primary text-3xl"></i>
                        <span class="font-bold text-2xl tracking-tight">ChildSafe</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">
                        A social impact platform dedicated to protecting children from exploitation and ensuring their right to a safe childhood.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Quick Links</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="index.php" class="hover:text-primary transition">Home</a></li>
                        <li><a href="about.php" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="report.php" class="hover:text-primary transition">Report Incident</a></li>
                        <li><a href="track.php" class="hover:text-primary transition">Track Status</a></li>
                        <li><a href="awareness.php" class="hover:text-primary transition">Know Child Rights</a></li>
                        <li><a href="reviews.php" class="hover:text-primary transition">Testimonials</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Resources</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="ngo.php" class="hover:text-primary transition">NGO Network</a></li>
                        <li><a href="ngo.php#volunteer" class="hover:text-primary transition">Volunteer</a></li>
                        <li><a href="faq.php" class="hover:text-primary transition">FAQ</a></li>
                        <li><a href="contact.php" class="hover:text-primary transition">Contact Us</a></li>
                        <li><a href="admin_login.php" class="hover:text-primary transition">Admin Portal</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b border-gray-700 pb-2">Emergency Contact</h3>
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                        <p class="text-sm text-gray-400 mb-2">Childline India (24/7):</p>
                        <a href="tel:1098" class="text-2xl font-bold text-danger hover:text-red-400 transition flex items-center gap-2">
                            <i class="fa-solid fa-phone-volume"></i> 1098
                        </a>
                        <p class="text-xs text-gray-500 mt-2">Toll-free, anonymous emergency helpline.</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-sm text-gray-500">
                &copy; <?php echo date("Y"); ?> ChildSafe Platform. All rights reserved. Designed for social impact.
            </div>
        </div>
    </footer>

    <!-- Leaflet JS for Maps -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Custom Scripts -->
    <script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
