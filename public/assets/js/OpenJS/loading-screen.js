document.addEventListener('DOMContentLoaded', function() {
    // Get the loading container and navigation elements
    const loadingContainer = document.querySelector('.loading-container');
    // const navItems = document.querySelectorAll('.nav-item-left, .nav-item-animation');

    // Initially hide nav items and remove animation classes
    // navItems.forEach(item => {
    //     item.style.opacity = '0';
    //     item.style.visibility = 'hidden';
    //     item.classList.remove('nav-item-left', 'nav-item-animation');
    // });

    // Function to hide the loading screen and trigger nav animations
    function hideLoadingScreen() {
        loadingContainer.classList.add('fade-out');
        loadingContainer.style.display ='none';
        // After loading screen fades out, trigger nav animations
        // setTimeout(() => {
        //     loadingContainer.style.display = 'none';

            // Show and trigger animations for nav items with staggered delay
            // navItems.forEach((item, index) => {
            //     setTimeout(() => {
                    // item.style.visibility = 'visible';
                    // Force a reflow to restart the animation
                    // void item.offsetWidth;
                    // Add back the appropriate animation class
                    // if (item.classList.contains('nav-item-left')) {
                    //     item.classList.add('nav-item-left');
                    // } else {
                    //     item.classList.add('nav-item-animation');
                    // }
                // }, index * 100); // Stagger each item by 100ms
        //     });
        // }, 500);
    }

    // Function to handle page load
    function handlePageLoad() {
        // Add a minimum display time of 2 seconds for the loading screen
        setTimeout(hideLoadingScreen, 3000);
    }

    // Check if the page is already loaded
    if (document.readyState === 'complete') {
        handlePageLoad();
    } else {
        // Wait for all resources to load
        window.addEventListener('load', handlePageLoad);
    }

    // Fallback: Hide loading screen after 5 seconds if something goes wrong
    setTimeout(hideLoadingScreen, 5000);
});