<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="relative bg-gray-900 text-white overflow-hidden">
    <div class="absolute inset-0 z-0">
        <!-- Using a placeholder pattern or dark gradient as requested since we can't fetch external images easily without knowing they work, but we will use a robust CSS gradient + Unsplash placeholder -->
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-800/90 to-gray-900/40 z-10"></div>
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" alt="Child Safety Background" class="w-full h-full object-cover opacity-60 mix-blend-overlay">
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-2xl animate-fade-in">
            <span class="inline-block py-1 px-3 rounded-full bg-primary/20 text-primary-light border border-primary/30 text-sm font-semibold tracking-wider mb-4 text-blue-300">
                SOCIAL IMPACT INITIATIVE
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                Protect Childhood.<br>
                <span class="text-secondary">Stop Child Labour.</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-xl">
                Every child deserves education, safety, and a future. Report child labour anonymously and help us protect vulnerable children in our communities.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="report.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-danger hover:bg-red-600 shadow-lg hover:shadow-xl transition-all duration-300">
                    Report a Case <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
                <a href="track.php" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all duration-300">
                    Track Complaint
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <div class="text-primary mb-2"><i class="fa-solid fa-file-signature text-4xl"></i></div>
                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1"><span class="stat-counter" data-target="1245">0</span>+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Total Reports</div>
            </div>
            <div class="p-4">
                <div class="text-accent mb-2"><i class="fa-solid fa-check-circle text-4xl"></i></div>
                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1"><span class="stat-counter" data-target="890">0</span>+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Cases Verified</div>
            </div>
            <div class="p-4">
                <div class="text-secondary mb-2"><i class="fa-solid fa-child-reaching text-4xl"></i></div>
                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1"><span class="stat-counter" data-target="530">0</span>+</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Children Rescued</div>
            </div>
            <div class="p-4">
                <div class="text-primary mb-2"><i class="fa-solid fa-handshake text-4xl"></i></div>
                <div class="text-4xl font-bold text-gray-900 dark:text-white mb-1"><span class="stat-counter" data-target="42">0</span></div>
                <div class="text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Active NGO Partners</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">How The System Works</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">A transparent, secure, and rapid response workflow to ensure every reported case is handled effectively.</p>
        </div>

        <div class="relative">
            <!-- Connecting Line (Desktop) -->
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                <!-- Step 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center hover-card relative">
                    <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900 text-primary rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-sm">1</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Report Incident</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Submit details anonymously via our secure portal with location data.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center hover-card relative">
                    <div class="w-16 h-16 mx-auto bg-amber-100 dark:bg-amber-900 text-secondary rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-sm">2</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Verification</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Admins and AI verify the report's authenticity and assign risk priority.</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center hover-card relative">
                    <div class="w-16 h-16 mx-auto bg-purple-100 dark:bg-purple-900 text-purple-600 rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-sm">3</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Investigation</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Local authorities and NGO partners are dispatched to the location.</p>
                </div>
                <!-- Step 4 -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center hover-card relative">
                    <div class="w-16 h-16 mx-auto bg-emerald-100 dark:bg-emerald-900 text-accent rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-sm">4</div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Child Support</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">The child is rescued, rehabilitated, and provided education support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Awareness Section -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Be Aware. Be The Change.</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Understanding child rights and the laws against child labour is the first step towards eradication.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-48 bg-blue-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fa-solid fa-scale-balanced text-6xl text-primary group-hover:scale-110 transition duration-300"></i>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Child Rights</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Every child has the fundamental right to survival, protection, development, and participation.</p>
                    <a href="awareness.php" class="text-primary font-medium text-sm hover:underline">Read more &rarr;</a>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-48 bg-amber-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-6xl text-secondary group-hover:scale-110 transition duration-300"></i>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Education Rights</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Free and compulsory education is guaranteed for children aged 6 to 14 years under the RTE Act.</p>
                    <a href="awareness.php" class="text-primary font-medium text-sm hover:underline">Read more &rarr;</a>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-48 bg-red-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fa-solid fa-gavel text-6xl text-danger group-hover:scale-110 transition duration-300"></i>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Labour Laws</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">The Child Labour (Prohibition and Regulation) Act strictly prohibits employing children below 14 years.</p>
                    <a href="awareness.php" class="text-primary font-medium text-sm hover:underline">Read more &rarr;</a>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group">
                <div class="h-48 bg-emerald-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fa-solid fa-hands-holding-circle text-6xl text-accent group-hover:scale-110 transition duration-300"></i>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">How You Can Help</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Report suspected cases immediately, support NGOs, and spread awareness in your community.</p>
                    <a href="ngo.php" class="text-primary font-medium text-sm hover:underline">Get involved &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Contact Section -->
<section class="py-16 bg-danger dark:bg-red-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,100 L100,0 Z"></path></svg>
    </div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <div class="w-20 h-20 mx-auto bg-white text-danger rounded-full flex items-center justify-center text-4xl mb-6 emergency-pulse shadow-lg">
            <i class="fa-solid fa-phone-volume"></i>
        </div>
        <h2 class="text-3xl md:text-4xl font-bold mb-4">See a child in immediate danger?</h2>
        <p class="text-lg text-red-100 mb-8 max-w-2xl mx-auto">Don't wait. Call the national child protection helpline immediately. Available 24/7, toll-free, and anonymous.</p>
        <a href="tel:1098" class="inline-block bg-white text-danger text-3xl font-extrabold px-8 py-4 rounded-full shadow-lg hover:scale-105 transition-transform duration-300">
            Dial 1098
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
