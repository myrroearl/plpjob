ScrollReveal().reveal('.about-heading, .newsevents-header, .awards-section-title, .future-section-title, .colleges-header, .section-title', {
    duration: 1000,
    scale: 0.8,
    easing: 'ease-in-out',
    reset: true,
});

ScrollReveal().reveal('.section-subtitle', {
  duration: 1500,
  origin: 'left',
  distance: '9rem',
  easing: 'ease-out',
  scale: 0.9,
  reset: true,
});

ScrollReveal().reveal('.future-btn-container', {
  duration: 1500,
  origin: 'left',
  distance: '20rem',
  easing: 'ease-out',
  scale: 0.8,
  reset: true,
  interval: 1000,
});

ScrollReveal().reveal('.see-more-btn', {
  duration: 1500,
  origin: 'right',
  distance: '9rem',
  easing: 'ease-out',
  scale: 0.9,
  reset: true,
});
  
ScrollReveal().reveal('.about-card-image', {
    duration: 1200,
    origin: 'left',
    distance: '100px',
    easing: 'ease-in-out',
    reset: true,
});

ScrollReveal().reveal('.about-card-content', {
    duration: 1200,
    origin: 'right',
    distance: '400px',
    easing: 'ease-in-out',
    reset: true,
});

ScrollReveal().reveal('.footer-animation', {  
    duration: 1000,
    origin: 'bottom',
    distance: '80px',
    easing: 'ease-in-out',
    reset: true,
});
// ScrollReveal().reveal('.news-card-container', {
//     duration: 1000,
//     origin: 'left',
//     distance: '60px',
//     easing: 'ease-in-out',
//     opacity: 0,
//     interval: 500,
//     reset: true,
// });

// News cards animation
ScrollReveal().reveal('.news-card-container', {
  duration: 800,
  opacity: 0,
  easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
  interval: 400,
  distance: '30px',
  origin: 'bottom',
  delay: 150,
  viewFactor: 0.2,
  reset: true,
  
});

// Events cards animation with slight delay
ScrollReveal().reveal('.events-card-container', {
  duration: 800,
  opacity: 0,
  easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
  interval: 400,
  distance: '30px',
  origin: 'bottom',
  delay: 150,  // Slightly delayed compared to news
  viewFactor: 0.2,
  reset: true,
});
  
ScrollReveal().reveal('.awards-section-content', {
  origin: 'bottom',
  distance: '120px',
  duration: 800,
  easing: 'cubic-bezier(0.5, 0, 0, 1)',
  interval: 200, // Adds staggered effect
  opacity: 0,
  reset: true,
});

ScrollReveal().reveal('.thumbnail', {
  origin: 'right',
  distance: '120px',
  duration: 1000,
  delay: 500,
  easing: 'cubic-bezier(0.5, 0, 0, 1)',
  opacity: 0,
  reset: true,
});

ScrollReveal().reveal('.nextPrevArrows .prev', {
  origin: 'left',
  distance: '120px',
  duration: 1000,
  easing: 'cubic-bezier(0.5, 0, 0, 1)',
  opacity: 0,
  reset: true,
});

ScrollReveal().reveal('.nextPrevArrows .next', {
  origin: 'right',
  distance: '120px',
  duration: 1000,
  easing: 'cubic-bezier(0.5, 0, 0, 1)',
  opacity: 0,
  reset: true,
});