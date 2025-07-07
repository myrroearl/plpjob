// Debounce function with improved performance
const debounce = (func, delay) => {
    let timer;
    return function (...args) {
        const context = this;
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(context, args), delay);
    };
};

document.addEventListener("DOMContentLoaded", () => {
    const timelineItems = document.querySelectorAll(".academic-animation");
    const observer = new IntersectionObserver(handleIntersection, {
        threshold: 0.2,
        rootMargin: "0px"
    });
    
    // Track scroll position to determine direction
    let lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let scrollDirection = "down";
    let animationFrame;
    
    // Update scroll direction using requestAnimationFrame for better performance
    const updateScrollDirection = () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop !== lastScrollTop) {
            scrollDirection = scrollTop > lastScrollTop ? "down" : "up";
            lastScrollTop = scrollTop;
        }
        animationFrame = requestAnimationFrame(updateScrollDirection);
    };
    
    // Start tracking scroll direction
    animationFrame = requestAnimationFrame(updateScrollDirection);
    
    // Handle intersection observer callback
    function handleIntersection(entries) {
        entries.forEach(entry => {
            const item = entry.target;
            const index = Array.from(timelineItems).indexOf(item);
            
            if (entry.isIntersecting) {
                // Remove any existing animation classes first
                item.classList.remove("slide-from-top", "slide-from-bottom");
                
                // Add delay based on index for sequential animation
                const delay = scrollDirection === "down" ? index * 0.2 : (timelineItems.length - 1 - index) * 0.2;
                item.style.animationDelay = `${delay}s`;
                
                // Apply the appropriate animation based on scroll direction
                item.classList.add(scrollDirection === "down" ? "slide-from-top" : "slide-from-bottom");
            }
        });
    }
    
    // Add each timeline item to the observer
    timelineItems.forEach(item => observer.observe(item));
    
    // Clean up resources when page is unloaded
    window.addEventListener("beforeunload", () => {
        cancelAnimationFrame(animationFrame);
        observer.disconnect();
    });
});