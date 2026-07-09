<?php include 'includes/header.php'; ?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16 animate-fade-in">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Frequently Asked Questions</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                Find answers to common questions about reporting child labour, our processes, and how you can help.
            </p>
        </div>

        <div class="space-y-4 animate-fade-in delay-100">
            <!-- FAQ 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <button class="w-full px-6 py-4 text-left font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none flex justify-between items-center" onclick="toggleFaq('faq1')">
                    <span>Is my identity truly safe when I report anonymously?</span>
                    <i id="icon-faq1" class="fa-solid fa-chevron-down text-primary transition-transform duration-300"></i>
                </button>
                <div id="faq1" class="px-6 py-4 text-gray-600 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 hidden">
                    Yes. When you select "Submit Report Anonymously", our system does not collect your name, email, or phone number. We only store the details of the incident and the unique Complaint ID generated for you to track the case.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <button class="w-full px-6 py-4 text-left font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none flex justify-between items-center" onclick="toggleFaq('faq2')">
                    <span>What happens after I submit a report?</span>
                    <i id="icon-faq2" class="fa-solid fa-chevron-down text-primary transition-transform duration-300"></i>
                </button>
                <div id="faq2" class="px-6 py-4 text-gray-600 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 hidden">
                    Once submitted, our admin team reviews the details and assigns a risk level. The case is then forwarded to the nearest affiliated NGO partner or local law enforcement for physical verification and rescue operations if necessary.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <button class="w-full px-6 py-4 text-left font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none flex justify-between items-center" onclick="toggleFaq('faq3')">
                    <span>How can I track the status of my complaint?</span>
                    <i id="icon-faq3" class="fa-solid fa-chevron-down text-primary transition-transform duration-300"></i>
                </button>
                <div id="faq3" class="px-6 py-4 text-gray-600 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 hidden">
                    After you submit a report, you will be given a unique Complaint ID (e.g., CLS2026...). Keep this ID safe. You can enter it on our <a href="track.php" class="text-primary hover:underline">Track Status</a> page at any time to see real-time updates from our administrators.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <button class="w-full px-6 py-4 text-left font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none flex justify-between items-center" onclick="toggleFaq('faq4')">
                    <span>Can my NGO partner with ChildSafe?</span>
                    <i id="icon-faq4" class="fa-solid fa-chevron-down text-primary transition-transform duration-300"></i>
                </button>
                <div id="faq4" class="px-6 py-4 text-gray-600 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 hidden">
                    Absolutely! We are always looking for verified NGOs to help manage cases on the ground. Please use the <a href="contact.php" class="text-primary hover:underline">Contact Us</a> form and select "NGO Partnership" as the subject. Our team will guide you through the verification process.
                </div>
            </div>
            
            <!-- FAQ 5 -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <button class="w-full px-6 py-4 text-left font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none flex justify-between items-center" onclick="toggleFaq('faq5')">
                    <span>What should I do if I see a child in immediate physical danger?</span>
                    <i id="icon-faq5" class="fa-solid fa-chevron-down text-primary transition-transform duration-300"></i>
                </button>
                <div id="faq5" class="px-6 py-4 text-gray-600 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 hidden">
                    If a child is in immediate, life-threatening danger, do not wait for our system to process a report. Please immediately call the national emergency child helpline (<strong>Dial 1098</strong> in India) or local police.
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleFaq(id) {
    const el = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        el.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>

<?php include 'includes/footer.php'; ?>
