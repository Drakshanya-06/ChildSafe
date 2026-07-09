document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const btn = document.querySelector('.mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // 2. Dark Mode Toggle
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    if (themeToggleBtn) {
        // Check local storage or system preference
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            lightIcon.classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            // Toggle icons
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            // If is dark mode
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });
    }

    // 3. Counter Animation (for statistics on Home page)
    const counters = document.querySelectorAll('.stat-counter');
    if (counters.length > 0) {
        const speed = 100; // Animation speed
        
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = +counter.getAttribute('data-target');
                    
                    const updateCount = () => {
                        const count = +counter.innerText;
                        // Calculate increment
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 20);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    
                    updateCount();
                    // Stop observing once animation starts
                    observer.unobserve(counter); 
                }
            });
        }, { threshold: 0.3 }); // Trigger when 30% visible
        
        counters.forEach(counter => {
            counter.innerText = '0'; // Ensure it starts at 0 visually
            observer.observe(counter);
        });
    }

    // 4. Anonymous Reporting Toggle
    const anonCheckbox = document.getElementById('anonymous_status');
    const reporterInfo = document.getElementById('reporter_info_section');
    
    if (anonCheckbox && reporterInfo) {
        anonCheckbox.addEventListener('change', function() {
            if (this.checked) {
                reporterInfo.style.opacity = '0.5';
                reporterInfo.querySelectorAll('input').forEach(input => {
                    input.disabled = true;
                    input.value = ''; // clear data
                });
            } else {
                reporterInfo.style.opacity = '1';
                reporterInfo.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });
            }
        });
    }

    // 5. Leaflet Map for Reporting (if map container exists)
    const mapContainer = document.getElementById('location_map');
    if (mapContainer && typeof L !== 'undefined') {
        const map = L.map('location_map').setView([20.5937, 78.9629], 5); // Default to India center
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        let marker;

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            
            // Set hidden fields for DB
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
        
        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 13);
                marker = L.marker([lat, lng]).addTo(map);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        }
    }
});
