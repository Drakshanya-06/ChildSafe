<?php include 'includes/header.php'; ?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-primary text-white overflow-hidden py-24">
        <div class="absolute inset-0 opacity-20">
            <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,100 L100,0 Z"></path></svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">About ChildSafe</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                We are a dedicated initiative committed to eradicating child labour and ensuring every child has access to education, safety, and a secure future.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-20 animate-fade-in delay-100">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-md border border-gray-100 dark:border-gray-700 hover-card">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 text-primary rounded-full flex items-center justify-center text-2xl mb-6">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    To create a robust, anonymous, and highly responsive platform that empowers citizens to report child labour instantly. We bridge the gap between concerned citizens, rescue authorities, and NGOs to facilitate immediate intervention and long-term rehabilitation.
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-md border border-gray-100 dark:border-gray-700 hover-card">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900 text-secondary rounded-full flex items-center justify-center text-2xl mb-6">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Vision</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    A world where no child is subjected to economic exploitation. We envision a society where every child's fundamental right to education, play, and a protected childhood is universally respected and fiercely guarded.
                </p>
            </div>
        </div>

        <!-- How It Started -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row mb-20 animate-fade-in delay-200">
            <div class="md:w-1/2 p-10 flex flex-col justify-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">The ChildSafe Story</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                    ChildSafe was born out of a critical need observed by social workers and software engineers. We realized that many people witness child labour daily but hesitate to report it due to fear of backlash, complicated bureaucratic processes, or simply not knowing who to contact.
                </p>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    By developing a secure, anonymous, and streamlined digital reporting mechanism, we've removed the barriers to action. Today, our platform acts as a vital technological backbone for NGOs and government agencies working tirelessly on the frontlines of child protection.
                </p>
            </div>
            <div class="md:w-1/2 bg-gray-200 dark:bg-gray-700 relative min-h-[300px]">
                <!-- Using a placeholder div pattern in place of an image -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary/80 to-secondary/80 mix-blend-multiply z-10"></div>
                <div class="absolute inset-0 flex items-center justify-center z-20">
                    <i class="fa-solid fa-hands-holding-child text-white/50 text-9xl"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
