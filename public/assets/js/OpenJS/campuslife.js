// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll) library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add parallax effect to the hero section
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            heroSection.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
        });
    }

    // Add animation to campus life cards on hover
    const campusLifeCards = document.querySelectorAll('.campus-life-card');
    campusLifeCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add animation to highlight cards
    const highlightCards = document.querySelectorAll('.highlight-card');
    highlightCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.highlight-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1)';
                icon.style.backgroundColor = 'rgba(11, 125, 63, 0.2)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.highlight-icon');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
                icon.style.backgroundColor = 'rgba(11, 125, 63, 0.1)';
            }
        });
    });

    // Add animation to testimonial cards
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    testimonialCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const authorImg = this.querySelector('.testimonial-author img');
            if (authorImg) {
                authorImg.style.borderColor = 'rgba(11, 125, 63, 0.5)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const authorImg = this.querySelector('.testimonial-author img');
            if (authorImg) {
                authorImg.style.borderColor = 'rgba(11, 125, 63, 0.2)';
            }
        });
    });

    // Add animation to CTA button
    const ctaButton = document.querySelector('.cta-section .btn-success');
    if (ctaButton) {
        ctaButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
        });
        
        ctaButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    }

    // Add navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }

    // Add wave animation
    // const waves = document.querySelector('.waves');
    // if (waves) {
    //     window.addEventListener('scroll', function() {
    //         const scrollPosition = window.scrollY;
    //         waves.style.transform = `translateY(${scrollPosition * 0.1}px)`;
    //     });
    // }

    // Add lazy loading for images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));

    // Gallery horizontal scroll with mouse wheel
    const galleryScroll = document.querySelector('.gallery-scroll');
    const prevButton = document.querySelector('.gallery-nav.prev');
    const nextButton = document.querySelector('.gallery-nav.next');
    
    if (galleryScroll) {
        // Mouse wheel horizontal scrolling
        galleryScroll.addEventListener('wheel', function(e) {
            e.preventDefault();
            galleryScroll.scrollLeft += e.deltaY;
        });
        
        // Navigation buttons
        if (prevButton && nextButton) {
            prevButton.addEventListener('click', function() {
                galleryScroll.scrollBy({
                    left: -400,
                    behavior: 'smooth'
                });
            });
            
            nextButton.addEventListener('click', function() {
                galleryScroll.scrollBy({
                    left: 400,
                    behavior: 'smooth'
                });
            });
        }
        
        // Drag to scroll functionality
        let isDown = false;
        let startX;
        let scrollLeft;
        
        galleryScroll.addEventListener('mousedown', function(e) {
            isDown = true;
            galleryScroll.classList.add('active');
            startX = e.pageX - galleryScroll.offsetLeft;
            scrollLeft = galleryScroll.scrollLeft;
        });
        
        galleryScroll.addEventListener('mouseleave', function() {
            isDown = false;
            galleryScroll.classList.remove('active');
        });
        
        galleryScroll.addEventListener('mouseup', function() {
            isDown = false;
            galleryScroll.classList.remove('active');
        });
        
        galleryScroll.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - galleryScroll.offsetLeft;
            const walk = (x - startX) * 2;
            galleryScroll.scrollLeft = scrollLeft - walk;
        });
    }

    // Testimonial Slider
    const slider = document.querySelector('.testimonials-slider');
    const track = document.querySelector('.testimonials-track');
    const cards = document.querySelectorAll('.testimonial-card');
    const dotsContainer = document.querySelector('.testimonial-dots');

    let currentIndex = 0;
    let slideInterval;
    const slideDuration = 5000; // 5 seconds
    const transitionDuration = 500; // 0.5 seconds

    // Clone first and last slides for infinite effect
    const firstClone = cards[0].cloneNode(true);
    const lastClone = cards[cards.length - 1].cloneNode(true);
    track.appendChild(firstClone);
    track.insertBefore(lastClone, cards[0]);

    // Create dots for original slides only
    cards.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('testimonial-dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.testimonial-dot');

    // Set initial position
    currentIndex = 1;
    updateSlider(false);

    function updateSlider(withTransition = true) {
        const cardWidth = slider.offsetWidth;
        const offset = -currentIndex * cardWidth;
        
        track.style.transition = withTransition ? `transform ${transitionDuration}ms ease-in-out` : 'none';
        track.style.transform = `translateX(${offset}px)`;

        // Update active states for original slides only
        const realIndex = (currentIndex - 1 + cards.length) % cards.length;
        
        cards.forEach((card, index) => {
            if (index === realIndex) {
                card.classList.add('active');
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            } else {
                card.classList.remove('active');
                card.style.opacity = '0.5';
                card.style.transform = 'scale(0.9)';
            }
        });

        // Update dots
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === realIndex);
        });
    }

    function goToSlide(index) {
        currentIndex = index + 1; // Account for cloned slide
        updateSlider();
        resetTimer();
    }

    function nextSlide() {
        if (currentIndex >= cards.length + 1) return;
        currentIndex++;
        updateSlider();
        
        // Check if we've reached the cloned slide
        if (currentIndex >= cards.length + 1) {
            setTimeout(() => {
                currentIndex = 1;
                updateSlider(false);
            }, transitionDuration);
        }
    }

    function prevSlide() {
        if (currentIndex <= 0) return;
        currentIndex--;
        updateSlider();
        
        // Check if we've reached the cloned slide
        if (currentIndex <= 0) {
            setTimeout(() => {
                currentIndex = cards.length;
                updateSlider(false);
            }, transitionDuration);
        }
    }

    function resetTimer() {
        clearInterval(slideInterval);
        startTimer();
    }

    function startTimer() {
        slideInterval = setInterval(nextSlide, slideDuration);
    }

    // Initialize slider
    startTimer();

    // Handle transition end
    track.addEventListener('transitionend', () => {
        if (currentIndex >= cards.length + 1) {
            currentIndex = 1;
            updateSlider(false);
        } else if (currentIndex <= 0) {
            currentIndex = cards.length;
            updateSlider(false);
        }
    });

    // Pause on hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });

    slider.addEventListener('mouseleave', () => {
        startTimer();
    });

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateSlider(false);
        }, 250);
    });

    // Add scroll up animation
    // const scrollUpBtn = document.getElementById('scrollUpBtn');
    // if (scrollUpBtn) {
    //     let lastScrollPosition = window.scrollY;
        
        // Show/hide button based on scroll position and direction
        // window.addEventListener('scroll', () => {
        //     const currentScrollPosition = window.scrollY;
        //     const isScrollingUp = currentScrollPosition < lastScrollPosition;
            
        //     if (currentScrollPosition > 300) {
        //         scrollUpBtn.style.display = 'block';
        //         if (isScrollingUp) {
        //             scrollUpBtn.style.animation = 'bounceUp 0.5s ease infinite';
        //         } else {
        //             scrollUpBtn.style.animation = 'fadeIn 0.5s ease forwards';
        //         }
        //     } else {
        //         scrollUpBtn.style.animation = 'fadeOut 0.5s ease forwards';
        //         setTimeout(() => {
        //             scrollUpBtn.style.display = 'none';
        //         }, 500);
        //     }
            
        //     lastScrollPosition = currentScrollPosition;
        // });

        // Add click event for smooth scroll to top
        // scrollUpBtn.addEventListener('click', () => {
        //     window.scrollTo({
        //         top: 0,
        //         behavior: 'smooth'
        //     });
        // });

        // Add hover effect
    //     scrollUpBtn.addEventListener('mouseenter', () => {
    //         scrollUpBtn.style.animation = 'none';
    //         scrollUpBtn.style.transform = 'translateY(-5px)';
    //         scrollUpBtn.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
    //     });

    //     scrollUpBtn.addEventListener('mouseleave', () => {
    //         const currentScrollPosition = window.scrollY;
    //         const isScrollingUp = currentScrollPosition < lastScrollPosition;
            
    //         if (currentScrollPosition > 300 && isScrollingUp) {
    //             scrollUpBtn.style.animation = 'bounceUp 0.5s ease infinite';
    //         } else if (currentScrollPosition > 300) {
    //             scrollUpBtn.style.animation = 'fadeIn 0.5s ease forwards';
    //         }
    //         scrollUpBtn.style.transform = 'translateY(0)';
    //         scrollUpBtn.style.boxShadow = 'none';
    //     });
    // }
}); 