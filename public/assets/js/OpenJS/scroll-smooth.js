$(document).ready(function(){
    // Show/hide scroll button based on scroll position
    $(window).scroll(function(){
        if(this.scrollY > 200) {
            $('#scrollUpBtn').css('display', 'block'); 
        } else{
            $('#scrollUpBtn').css('display', 'none'); 
        }
    });

    // Scroll to top only when the scroll button is clicked
    $('#scrollUpBtn').click(function(e){
        e.preventDefault();
        $('html').animate({scrollTop: 0});
        $('html').css("scrollBehavior", "auto");
    });

    // Handle offcanvas navigation links
    $('.offcanvas-body .navbar-nav .nav-link').click(function(e) {
        const href = $(this).attr('href');
        
        // Only handle links with hash (#) targets
        if (href && href.startsWith('#')) {
            e.preventDefault();
            
            // Get the target element
            const target = $(href);
            
            if (target.length) {
                // Smooth scroll to the target
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 2000);
            }
        }

        // Close the offcanvas menu
        const offcanvas = document.getElementById('mobileMenu');
        const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
        if (bsOffcanvas) {
            bsOffcanvas.hide();
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                // Smooth scroll to the target element
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});