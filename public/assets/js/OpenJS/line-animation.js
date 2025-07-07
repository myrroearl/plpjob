const createScrollAnimationObserver = () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      // Check if the element is intersecting
      if (entry.isIntersecting) {
        // Add the animate class when the element is in view
        entry.target.classList.add('animate');
      } else {
        // Remove the animate class when the element is out of view
        // This allows re-animation when scrolling back
        entry.target.classList.remove('animate');
      }
    });
  }, {
    threshold: 0.5 // Trigger when 50% of the element is visible
  });
  
  // Function to observe all elements with a specific class
  const observeElements = (selector) => {
    const elements = document.querySelectorAll(selector);
    elements.forEach(element => observer.observe(element));
  };
  
  // Observe the heading
  observeElements('.about-heading');
  observeElements('.newsevents-header');
  observeElements('.awards-section-title');
  observeElements('.colleges-heading');
  observeElements('.section-header');
  observeElements('.categories-title');
observeElements('.section-title');
  
  // Return the observer in case you want to add more elements or disconnect later
  return observer;
};

// Create the observer
const scrollAnimationObserver = createScrollAnimationObserver();