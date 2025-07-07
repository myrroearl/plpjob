let nextBtn = document.querySelector('.next')
let prevBtn = document.querySelector('.prev')

let slider = document.querySelector('.slider')
let sliderList = slider.querySelector('.slider .list')
let thumbnail = document.querySelector('.slider .thumbnail')
let thumbnailItems = thumbnail.querySelectorAll('.item')

// Initialize the first thumbnail move (if needed)
thumbnail.appendChild(thumbnailItems[0])

// Button events
nextBtn.onclick = () => moveSlider('next')
prevBtn.onclick = () => moveSlider('prev')

// Slider movement logic
function moveSlider(direction) {
    let sliderItems = sliderList.querySelectorAll('.item')
    let thumbnailItems = document.querySelectorAll('.thumbnail .item')

    if (direction === 'next') {
        sliderList.appendChild(sliderItems[0])
        thumbnail.appendChild(thumbnailItems[0])
        slider.classList.add('next')
    } else {
        sliderList.prepend(sliderItems[sliderItems.length - 1])
        thumbnail.prepend(thumbnailItems[thumbnailItems.length - 1])
        slider.classList.add('prev')
    }

    slider.addEventListener('animationend', () => {
        slider.classList.remove('next', 'prev')
    }, { once: true })
}

// ✅ Infinite Autoplay - runs no matter what
function startAutoplay() {
    setInterval(() => {
        moveSlider('next')
    }, 3000) // Change speed here if needed
}

// Start autoplay immediately
startAutoplay()
