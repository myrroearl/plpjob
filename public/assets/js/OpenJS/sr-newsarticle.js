// Initialize ScrollReveal
// const sr = ScrollReveal();

// Configure breadcrumb animation
// sr.reveal('.breadcrumb', {
//     duration: 1000,
//     origin: 'top',
//     distance: '1rem',
//     easing: 'ease-in-out',
//     reset: true
// });

// Configure article image animation
// sr.reveal('.article-featured-image', {
//     duration: 1000,
//     origin: 'left',
//     distance: '20px',
//     easing: 'ease-in-out',
//     reset: true,
//     scale: 0.8
// });

ScrollReveal().reveal('.article-title, .article-featured-image', {
    duration: 1000,
    origin: 'left',
    distance: '5rem',
    easing: 'ease-in-out',
});

ScrollReveal().reveal('.related-news, .categories', {
    duration: 1000,
    origin: 'right',
    distance: '5rem',
    easing: 'ease-in-out',
});

ScrollReveal().reveal('.breadcrumb', {
    duration: 1000,
    origin: 'top',
    distance: '5rem',
    easing: 'ease-in-out',
});

ScrollReveal().reveal('.article-meta', {
    duration: 1000,
    origin: 'bottom',
    distance: '5rem',
    easing: 'ease-in-out',
});