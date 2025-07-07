// Simple parallax effect on scroll
window.addEventListener('scroll', function() {
  const scrollY = window.scrollY;
  
  // Apply parallax effect to elements with parallax-bg class
  document.querySelectorAll('.parallax-bg').forEach(function(element) {
    const speed = element.getAttribute('data-speed') || 0.5;
    element.style.transform = `translateY(${scrollY * speed}px)`;
  });
  
  // Apply subtle movement to floating elements based on scroll
  document.querySelectorAll('.float-element').forEach(function(element, index) {
    const direction = index % 2 === 0 ? 1 : -1;
    const amplitude = 0.02;
    element.style.transform = `translateY(${Math.sin(scrollY * 0.003) * 10 * direction * amplitude}rem)`;
  });
});

// Parallax effect for waves and background layers
document.addEventListener('DOMContentLoaded', function() {
    const parallaxLayers = document.querySelectorAll('.parallax-layer, .wave-parallax');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset;
        const viewportHeight = window.innerHeight;
        const docHeight = document.body.scrollHeight;
        const totalScrollableDistance = docHeight - viewportHeight;
        const scrollProgress = scrollTop / totalScrollableDistance;
        
        // Apply parallax effect to each layer
        parallaxLayers.forEach(layer => {
            const speed = parseFloat(layer.getAttribute('data-speed')) || 0.05;
            const yPos = -scrollProgress * 100 * speed;
            
            if (layer.classList.contains('wave-parallax')) {
                // For SVG wave elements
                layer.setAttribute('y', (parseFloat(layer.getAttribute('y') || 0) + yPos/50));
            } else {
                // For background layers
                layer.style.transform = `translate3d(0, ${yPos}%, 0)`;
            }
        });
    });
    
    // Add mousemove parallax effect for extra interactivity
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        parallaxLayers.forEach(layer => {
            const speed = parseFloat(layer.getAttribute('data-speed')) || 0.05;
            const xPos = (mouseX - 0.5) * speed * 100;
            const yPos = (mouseY - 0.5) * speed * 50;
            
            if (!layer.classList.contains('wave-parallax')) {
                layer.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
            }
        });
    });
});

// Smooth scroll effect for a better user experience
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

