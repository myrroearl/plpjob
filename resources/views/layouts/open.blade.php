<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alumni Job Portal') }} - @yield('title')</title>
    
    <!-- Preconnect and DNS prefetch -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/plp-logo.png') }}" type="image/x-icon">
    
    
    
</head>
<body>
    
    <!-- <div class="loading-container">
        <div class="loader-content">
            <div class="school-logo">
                <img src="/assets/img/OpenImages//plp.png" alt="PLP Logo">
                <div class="logo-glow"></div>
            </div>
            <div class="school-text">
                <h1 class="school-name">PAMANTASAN LUNGSOD NG</h1>
                <h2 class="school-name-pasig">PASIG</h2>
            </div>
            <div class="loading-bar-container">
                <div class="loading-bar">
                    <div class="loading-progress"></div>
                </div>
                <div class="wave"></div>
            </div>
            <div class="loading-text">
                <span>L</span>
                <span>o</span>
                <span>a</span>
                <span>d</span>
                <span>i</span>
                <span>n</span>
                <span>g</span>
            </div>
        </div>
    </div> -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler mobile-menu-btn mobile-menu-btn-custom text-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars" style="font-size: 30px;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item nav-item-left" style="animation-delay: 0.6s;">
                        <a class="nav-link text-light" aria-current="page" href="/">HOME</a>
                    </li>
                    <li class="nav-item nav-item-left" style="animation-delay: 0.4s;">
                        <a class="nav-link text-light" href="{{ route('aboutpage') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item d-flex flex-column navbar-customized-dropdown nav-item-left" style="animation-delay: 0.2s;">
                        <div class="d-flex">
                            <a class="nav-link text-light" href="/">NEWS & EVENTS</a>
                            <i class="fa-solid fa-caret-down text-light d-flex justify-content-center align-items-center"></i>
                        </div>
                        <ul class="dropdown-list-news">
                            <li><a href="{{ route('newspage') }}" class="text-decoration-none">News</a></li>
                            <li><a href="{{ route('eventspage') }}" class="text-decoration-none">Events</a></li>
                            <li><a href="/announcements page/announcements.html" class="text-decoration-none">Announcements</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="right-nav-side d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item nav-item-animation" style="animation-delay: 0.2s;">
                            <a class="nav-link text-light" href="{{ route('contactpage') }}">CONTACT US</a>
                        </li>
                    </ul>
                    <form class="d-flex nav-item-animation" role="search" style="animation-delay: 0.4s;">
                        <input class="form-control customized-search" style="font-size: 13px;" type="search" placeholder="Search" aria-label="Search" placeholder="Search">
                        <button class="btn text-light" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg bottom-nav indention-bottom-nav">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 me-auto">
                    <li class="nav-item nav-item-left" style="animation-delay: 0.6s;">
                        <a class="nav-link text-black" aria-current="page" href="{{ route('academics') }}">ACADEMICS</a>
                    </li>
                    <li class="nav-item nav-item-left" style="animation-delay: 0.4s;">
                        <a class="nav-link text-black" href="">ADMISSION</a>
                    </li>
                    <li class="nav-item nav-item-left" style="animation-delay: 0.2s;">
                        <a class="nav-link text-black" href="{{ route('campus_life') }}">PLP LIFE</a>
                    </li>
                </ul>
                <div class="right-side-bottom-nav">
                    <ul class="navbar-nav mb-2 mb-lg-0 me-auto">
                        <li class="nav-item nav-item-animation" style="animation-delay: 0.2s;">
                            <a class="nav-link text-black" aria-current="page" href="{{ route('researchpage') }}">RESEARCH & EXTENSION</a>
                        </li>
                        <li class="nav-item nav-item-animation" style="animation-delay: 0.4s;">
                            <a class="nav-link text-black" href="{{ route('home') }}" target="_blank">ALUMNI</a>
                        </li>   
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="logo-container">
        <div class="logo-wrapper pt-2 ps-3 pe-3 pb-2">
            <div class="text-header-logo text-center lh-1">
                <p class="m-0 text-center">PAMANTASAN NG LUNGSOD NG</p>
                <h1 class="m-0 fw-bold text-center">PASIG</h1>
            </div>
            <div class="logo-header">
                <img src="{{ asset('/assets/img/OpenImages/plp.png') }}" alt="PLP Logo" class="plp-logo">
            </div>
        </div>
    </div>

    <button id="scrollUpBtn" class="position-fixed border border-0 pe-auto rounded-circle fs-4" title="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <main>
        {{ $slot }}
    </main>

    <section class="future-section future-parallax">
        <div class="container future-section-container d-flex justify-content-center align-items-center flex-column">
            <h1 class="future-section-title">Ready to Take <span>the Next Step?</span></h1>
            <div class="container">
                <div class="future-section-content row">
                    <div class="col-lg-4 p-3 d-flex justify-content-center future-btn-container">
                        <a href="" class="explore-btn text-decoration-none float-element">EXPLORE PROGRAMS</a>
                    </div>
                    <div class="col-lg-4 p-3 d-flex justify-content-center future-btn-container">
                        <a href="" class="apply-btn text-decoration-none float-element">APPLY NOW</a>
                    </div>
                    <div class="col-lg-4 p-3 d-flex justify-content-center future-btn-container">
                        <a href="" class="contact-btn text-decoration-none float-element">CONTACT US</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Parallax Waves Container-->
    <div class="waves-parallax-container footer-animation">
        <div class="parallax-layer layer1" data-speed="0.08"></div>
        <div class="parallax-layer layer2" data-speed="0.12"></div>
        
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
        <use xlink:href="#gentle-wave" x="48" y="0" fill="#2EA86B" class="wave-parallax" data-speed="0.06" />
        <use xlink:href="#gentle-wave" x="48" y="4" fill="#179457" class="wave-parallax" data-speed="0.04" />
        <use xlink:href="#gentle-wave" x="48" y="6" fill="#0B7D3F" class="wave-parallax" data-speed="0.03" />
        <use xlink:href="#gentle-wave" x="48" y="8" fill="#0b7d3fcd" class="wave-parallax" data-speed="0.02" />
        </g>
        </svg>
    </div>
    <!--Waves end-->

    <footer>
        <div class="container footer-container">
            <div class="row">
                <div class="col-12 col-lg-6 col-xxl-3">
                    <div class="d-flex gap-1">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('/assets/img/OpenImages//plp.png') }}" alt="" class="img-fluid" width="90px">
                        </div>
                        <div class="image-logo-content text-center lh-1">
                            <p class="m-0 small-lungsod">PAMANTASAN LUNGSOD NG</p>
                            <p class="m-0 big-pasig">PASIG</p>
                        </div>
                    </div>
                    <p class="mt-3">Providing quality education for a sustainable future.</p>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3 d-flex flex-column text-start">
                    <h5 class="footer-heading mb-3">Contact Information</h5>
                    <p class="m-0"><i class="fas fa-map-marker-alt me-2"></i>12-B Alcalde Jose, Pasig, 1600 Metro Manila</p>
                    <p class="m-0"><i class="fas fa-phone me-2"></i>2-8643-1014</p>
                    <p class="m-0"><i class="fas fa-envelope me-2"></i>info@plp.edu.ph</p>
                    <p class="m-0"><i class="fas fa-globe me-2"></i>www.plp.edu.ph</p>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3 d-flex flex-column">
                    <h5 class="footer-heading mb-3">Quick Links</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#"><i class="fas fa-angle-right me-2"></i>Academic Programs</a></li>
                        <li><a href="#"><i class="fas fa-angle-right me-2"></i>Admissions</a></li>
                        <li><a href="#"><i class="fas fa-angle-right me-2"></i>Research & Extension</a></li>
                        <li><a href="#"><i class="fas fa-angle-right me-2"></i>Campus Life</a></li>
                        <li><a href="#"><i class="fas fa-angle-right me-2"></i>About PLP</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-6 col-xxl-3 d-flex flex-column">
                    <h5 class="footer-heading mb-3">Connect With Us</h5>
                    <p>Stay updated with our latest news and events</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="mt-3">
                        <h6>Subscribe to our Newsletter</h6>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-success" type="submit">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-boder"></div>
        <div class="container footer-bottom p-2">
            <div class="row">
                <div class="col-md-6">
                    <p class="m-0">© 2025 Pamantasan Lungsod ng Pasig. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3 text-white">Privacy Policy</a>
                    <a href="#" class="me-3 text-white">Terms of Use</a>
                    <a href="#" class="text-white">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center" id="mobileMenuLabel">
                <img src="{{ asset('/assets/img/OpenImages/plp.png') }}" alt="PLP Logo" class="offcanvas-logo me-2" width="40" height="40">
                <h5 class="offcanvas-title">PLP Menu</h5>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body">
            <div class="mobile-search mb-3">
                <form class="d-flex" role="search">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-search" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <nav class="mobile-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-2"></i>HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aboutpage') }}">
                            <i class="fas fa-info-circle me-2"></i>ABOUT US
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <div class="d-flex justify-content-between">
                            <a class="nav-link" href="/">
                                <i class="fas fa-newspaper me-2"></i>NEWS & EVENTS
                            </a>
                            <i class="fa-solid fa-caret-down text-primary d-flex justify-content-center align-items-center cursor-pointer p-2 dropdown-icon" onclick="toggleDropdown()"></i>
                        </div>
                        <ul class="dropdown-list-responsive" id="dropdown-list-responsive">
                            <li class="text-black"><a href="{{ route('newspage') }}">News</a></li>
                            <li class="text-black"><a href="{{ route('eventspage') }}">Events</a></li>
                            <li class="text-black"><a href="">Announcements</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="{{ route('academics') }}">
                            <i class="fas fa-graduation-cap me-2"></i>ACADEMICS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user-plus me-2"></i>ADMISSION
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campus_life') }}">
                            <i class="fas fa-university me-2"></i>CAMPUS LIFE
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('researchpage') }}">
                            <i class="fas fa-flask me-2"></i>RESEARCH & EXTENSION
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-users me-2"></i>ALUMNI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contactpage') }}">
                            <i class="fas fa-phone me-2"></i>CONTACT US
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

   
    
</body>
</html>
