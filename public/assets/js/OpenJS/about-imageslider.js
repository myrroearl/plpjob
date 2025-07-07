new Swiper('.card-wrapper', {
    loop: true,
    spaceBetween: 30,
    autoplay: {
        delay: 3000, // Adjust time (in milliseconds) between slides
        disableOnInteraction: false, // Keeps autoplay running even when user interacts
    },
    // Pagination bullets
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
    },
    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    // Responsive breakpoints
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 3
        }
    }
});
