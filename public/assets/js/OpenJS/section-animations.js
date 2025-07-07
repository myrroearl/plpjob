/**
 * Section Animations for Research Page
 * This file handles animations for sections when they are displayed
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all sections with IDs
    const sections = document.querySelectorAll('section[id]');
    
    // Add animation classes to each section
    sections.forEach(section => {
        // Add initial animation classes
        section.classList.add('section-animation');
        
        // Add animation delay based on section index
        const index = Array.from(sections).indexOf(section);
        section.style.setProperty('--animation-delay', `${index * 0.1}s`);
    });
    
    // Function to animate section when it becomes visible
    function animateSection(section) {
        if (!section) return;
        
        // Reset animation state
        section.classList.remove('section-animated');
        
        // Force reflow to restart animation
        void section.offsetWidth;
        
        // Add animation class
        section.classList.add('section-animated');
        
        // Animate child elements with staggered delays
        const animatedElements = section.querySelectorAll('.animate-on-scroll');
        animatedElements.forEach((element, index) => {
            element.style.setProperty('--element-delay', `${index * 0.1}s`);
            element.classList.add('element-animated');
        });
    }
    
    // Override the existing section display logic in research.js
    const originalNavLinks = document.querySelectorAll('.research-nav .nav-link');
    
    if (originalNavLinks && originalNavLinks.length > 0) {
        originalNavLinks.forEach(link => {
            // Store the original click handler
            const originalClickHandler = link.onclick;
            
            // Remove the original click handler
            link.onclick = null;
            
            // Add our enhanced click handler
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
                // Remove active class from all nav links
                originalNavLinks.forEach(navLink => navLink.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
                
                // Hide all sections first
                sections.forEach(section => {
                    section.classList.remove('active');
                    section.style.display = 'none';
                });
                
                // Show and animate the target section
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                    targetSection.style.display = 'block';
                    
                    // Animate the section
                    animateSection(targetSection);
                    
                    // Scroll to section
                    window.scrollTo({
                        top: targetSection.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    // Animate the first active section on page load
    const activeSection = document.querySelector('section[id].active');
    if (activeSection) {
        animateSection(activeSection);
    } else if (sections.length > 0) {
        // If no section is active, activate and animate the first one
        sections[0].classList.add('active');
        sections[0].style.display = 'block';
        animateSection(sections[0]);
        
        // Also activate the corresponding nav link
        const firstNavLink = document.querySelector(`.research-nav .nav-link[href="#${sections[0].id}"]`);
        if (firstNavLink) {
            firstNavLink.classList.add('active');
        }
    }
}); 