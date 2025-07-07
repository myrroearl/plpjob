function toggleDropdown() {
    const dropdownList = document.getElementById('dropdown-list-responsive');
    const dropdownIcon = document.querySelector('.dropdown-icon');
    const dropdownContainer = dropdownIcon.closest('.nav-item');
    
    // Toggle dropdown visibility
    dropdownList.classList.toggle('show');
    
    // Toggle icon rotation
    dropdownIcon.classList.toggle('active');
    
    if (dropdownList.classList.contains('show')) {
        // Get the height of the dropdown
        const dropdownHeight = dropdownList.scrollHeight;
        
        // Create space for the dropdown by adjusting the container's margin or padding
        dropdownContainer.style.transition = 'padding-bottom 0.3s ease-out';
    } else {
        // Reset the container's spacing
        dropdownContainer.style.paddingBottom = '0';
    }
}

function toggleCategories() {
    const dropdownList = document.getElementById('categories-list');
    const dropdownIcon = document.querySelector('.categories-icon');
    const dropdownContainer = dropdownIcon.closest('.categories-container');
    
    // Toggle dropdown visibility
    dropdownList.classList.toggle('show');
    
    // Toggle icon rotation
    dropdownIcon.classList.toggle('active');
    
    if (dropdownList.classList.contains('show')) {
        // Get the height of the dropdown
        const dropdownHeight = dropdownList.scrollHeight;
        
        // Create space for the dropdown by adjusting the container's margin or padding
        dropdownContainer.style.transition = 'padding-bottom 0.3s ease-out';
    } else {
        // Reset the container's spacing
        dropdownContainer.style.paddingBottom = '0';
    }
}