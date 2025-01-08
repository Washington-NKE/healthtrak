document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const doctorSelect = document.getElementById('doctor');
    
    if (dateInput && timeSelect && doctorSelect) {
        async function updateTimeSlots() {
            const date = dateInput.value;
            const doctorId = doctorSelect.value;
            
            if (date && doctorId) {
                const response = await fetch(`get_available_slots.php?doctor_id=${doctorId}&date=${date}`);
                const availableSlots = await response.json();
                
                timeSelect.innerHTML = '';
                availableSlots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot;
                    option.textContent = slot;
                    timeSelect.appendChild(option);
                });
            }
        }
        
        dateInput.addEventListener('change', updateTimeSlots);
        doctorSelect.addEventListener('change', updateTimeSlots);
    }
});

///////////DASHBOARD////////////
// Dropdown toggle logic
document.addEventListener('DOMContentLoaded', () => {
    const menuIcon = document.querySelector('.dropdown-trigger');
    const dropdownMenu = document.getElementById('dropdown-menu');

    menuIcon.addEventListener('click', (event) => {
        event.preventDefault();
        const isMenuOpen = dropdownMenu.style.display === 'block';
        dropdownMenu.style.display = isMenuOpen ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!menuIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
});


function toggleSidebar() {
    const sidebar = document.getElementById("mySidebar");
    const main = document.getElementById("main");
    const logo = document.querySelector('.brand-logo');
    
    if (sidebar.style.width === "250px") {
        sidebar.style.width = "0";
        main.style.marginLeft = "0";
        logo.style.display = "block";
    } else {
        sidebar.style.width = "250px";
        main.style.marginLeft = "250px";
        logo.style.display = "none";
    }
}

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById("mySidebar");
    const menuIcon = document.querySelector('.menu-icon');
    
    if (!sidebar.contains(event.target) && event.target !== menuIcon && sidebar.style.width === "250px") {
        sidebar.style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }
});