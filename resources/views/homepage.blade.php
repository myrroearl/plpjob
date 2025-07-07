<x-open-layout>
    @section('title', 'Homepage')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/custom.css') }}">
    <!-- <link rel="stylesheet" href="carousel.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/slider.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/parallax.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/aos.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-animate.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scrollreveal.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/line-animation.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/loading-screen.js') }}"></script>

    


    <section class="unaa" id="home">
        <div class="unaa-content">
            <div class="background-picture bg-light">
            
                <iframe
                    id="youtubePlayer"
                    width="560" 
                    height="315" 
                    src="https://www.youtube.com/embed/zXevSZh2Xcg?enablejsapi=1&autoplay=1&mute=1&loop=1&playlist=zXevSZh2Xcg&controls=0&modestbranding=1&rel=0&disablekb=1&fs=0&iv_load_policy=3&si=_kPvxCAPICrWwwSQ" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
            </div>
            <div class="academic-programs-container">
                <div class="container-fluid academic-programs">
                    <div class="row">
                        <div class="first p-4 text-center col-12 col-sm-6 col-lg-3 d-flex justify-content-end flex-column academic-animation" style="animation-delay: 0.2s;">
                            <div class="first-header">
                                <i class="fa-solid fa-user-graduate fs-1 icon1 mb-2"></i>
                                <p class="m-0 fs-3">Academic Programs</p>
                            </div>
                            <div class="horizontal-line bg-white mt-3 mb-3"></div>
                            <p style="text-align: justify;">Pamantasan Lungsod ng Pasig (PLP) offers free tuition for qualified students, it provides affordable and accessible education to it's students.</p>
                            <a href="colleges.html" class="learn-btn p-2 text-decoration-none">
                                Learn More  <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                        <div class="second p-4 text-center bg-warning col-12 col-sm-6 col-lg-3 d-flex justify-content-end flex-column academic-animation" style="animation-delay: 0.4s;">
                            <div class="second-header">
                                <i class="fa-solid fa-calendar-days fs-1 icon2 mb-2"></i>
                                <p class="m-0 fs-3">Academic Calendar</p>
                            </div>
                            <div class="horizontal-line bg-white mt-3 mb-3"></div>
                            <p style="text-align: justify;">Stay updated with PLP's academic schedule, including enrollment periods, examination dates, holidays, and other important academic deadlines.</p>
                            <a href="events.html" class="learn-btn p-2 text-decoration-none">
                                Learn More  <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                        <div class="third p-4 text-center bg-danger col-12 col-sm-6 col-lg-3 d-flex justify-content-end flex-column academic-animation" style="animation-delay: 0.6s;">
                            <div class="third-header">
                                <i class="fa-solid fa-newspaper fs-1 icon3 mb-2"></i>
                                <p class="m-0 fs-3">Latest News</p>
                            </div>
                            <div class="horizontal-line bg-white mt-3 mb-3"></div>
                            <p style="text-align: justify;">Get the latest updates on university events, achievements, announcements, and important information about the PLP community.</p>
                            <a href="news.html" class="learn-btn p-2 text-decoration-none">
                                Learn More  <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                        <div class="fourth p-4 text-center bg-success col-12 col-sm-6 col-lg-3 d-flex justify-content-end flex-column academic-animation" style="animation-delay: 0.8s;">
                            <div class="fourth-header">
                                <i class="fa-solid fa-users fs-1 icon4 mb-2"></i>
                                <p class="m-0 fs-3">Student Life</p>
                            </div>
                            <div class="horizontal-line bg-light mt-3 mb-3"></div>
                            <p style="text-align: justify;">Discover student organizations, campus activities, sports events, and various opportunities for personal and professional growth at PLP.</p>
                            <a href="campus_life.html" class="learn-btn p-2 text-decoration-none">
                                Learn More  <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section about-parallax" id="about">
        <div class="container about-section-container">
            <h1 class="about-heading">Discover PLP's Legacy</h1>
            
            <div class="row sana">
                <div class="col-lg-12">
                    <div class="about-card">
                        <div class="row g-0">
                            <div class="col-lg-4 about-card-image">
                                <div class="">
                                    <img src="{{ asset('/assets/img/OpenImages/image4.png') }}"  alt="University Building" class="about-image">
                                </div>
                            </div>
                            <div class="col-lg-8 about-card-content">
                                <div class="about-content d-flex justify-content-center align-items-start flex-column">
                                    <div>
                                        <h2>Pamantasan ng Lungsod ng Pasig</h2>
                                        <p>
                                            A public university in Pasig City, Philippines, established to provide affordable and quality education to Pasig residents. It offers undergraduate programs in fields like business, education, engineering, IT, and health sciences. Funded by the local government, PLP provides free tuition for qualified students, promoting accessible higher education.
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('aboutpage') }}" class="read-more-btn">
                                            Read More <i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="caro" id="colleges">
        <div class="colleges-header text-center mb-4">
            <h1 class="colleges-heading m-0">Our Colleges</h1>
        </div>

        <div class="slider">

            <div class="list">
    
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/ccs.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Computer Studies</div>
                        <div class="description">
                            Offering cutting-edge programs in Computer Science, Information Technology, and Information Systems. Develop your skills in programming, software development, and digital innovation.
                        </div>
                        <div class="button">
                            <button onclick="window.location.href = 'ccs.html'">Explore Program</button>
                        </div>
                    </div>
                </div>
    
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/cba.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Business Administration</div>
                        <div class="description text-start">
                            Developing business leaders through comprehensive programs in Management, Marketing, and Finance. Excel in the dynamic world of business.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>
    
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/educ.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Education</div>
                        <div class="description text-start">
                            Developing future educators through innovative teaching methodologies and comprehensive pedagogical training. Create meaningful impact in education.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>
    
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/coe.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Engineering</div>
                        <div class="description text-start">
                            Building tomorrow's innovators through programs in Civil, Mechanical, and Electrical Engineering. Transform ideas into reality with practical engineering solutions.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/cas.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Arts and Science</div>
                        <div class="description text-start">
                            Understanding human behavior and mental processes through scientific research and practical applications. Make a difference in mental health and well-being.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/hm.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of International Hospitality Management</div>
                        <div class="description text-start">
                            We train future hospitality professionals with a perfect mix of skill, discipline, and passion. Our hands-on, industry-focused approach ensures graduates are ready to lead with excellence.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/nurse.png') }}" alt="">
    
                    <div class="content">
                        <div class="title">College of Nursing</div>
                        <div class="description text-start">
                            Providing comprehensive healthcare education with state-of-the-art facilities and hands-on clinical experience. Shape the future of healthcare with evidence-based nursing practice.
                        </div>
                        <div class="button">
                            <button>Explore Program</button>
                        </div>
                    </div>
                </div>
    
            </div>
    
    
            <div class="thumbnail">
    
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/ccs-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/cba-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/educ-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/coe-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/cas-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/hm-thumbnail.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('/assets/img/OpenImages/colleges/nurse-thumbnail.png') }}" alt="">
                </div>
    
            </div>
    
    
            <div class="nextPrevArrows">
                <button class="prev">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button class="next">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
    
    
        </div>
    </div>

    <section id="newsevents" class="newsevents-section">
        <div class="container newsevents-section-container">
            <div class="newsevents-header text-center position-relative">
                <h1 class="news-heading m-0">Stay Updated with PLP!</h1>
                <em class="m-0">Check out the lastest updates and upcoming events happening at PLP!</em>
            </div>
            <div class="row plpnews-content">
                <div class="col-lg-12">
                    <h2 class="section-subtitle mb-4">PLP News</h2>
                    <div class="row plpnews g-4">
                        <div class="col-12 col-sm-6 col-lg-3 news-card-container">
                            <div class="news-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" class="plp-lastest-news" alt="News 1">
                                    <div class="category-tag">Campus News</div>
                                </div>
                                <div class="news-content">
                                    <div class="news-date">
                                        <i class="far fa-calendar-alt me-2"></i>January 3, 2025
                                    </div>  
                                    <div class="meaning">
                                        <h3>#SEAOIL proudly awards ₱100,000 to ECT board exam topnotcher!</h3>
                                        <p>Engr. Jose Reynaldo Cube, a graduate of the Pamantasan ng Lungsod ng Pasig (PLP) who made it to the Top 3 of the Electronics Technician (ECT) board exams in October 2023, is the first recipient of our Angat Pangarap program.</p>
                                        <div class="d-flex justify-content-end">
                                            <div class="read-more-container">
                                                <a href="./news-article.html" class="read-more">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="news-meta d-flex justify-content-between">
                                        <span><i class="fas fa-calendar-check me-1"></i>4 months ago</span>
                                        <span><i class="fas fa-share-alt me-1"></i>Share</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 news-card-container">
                            <div class="news-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" class="plp-lastest-news" alt="News 2">
                                    <div class="category-tag">Research</div>
                                </div>
                                <div class="news-content">
                                    <div class="news-date">
                                        <i class="far fa-calendar-alt me-2"></i>March 15, 2024
                                    </div>  
                                    <div class="meaning">
                                        <h3>Application for Admission, Academic Year 2025-2026</h3>
                                        <p>Admission process for Student-Applicants for AY 2025-26, For Incoming Freshmen Students, Fill-out the Online Application Form that will be posted on January 6, 2025 at the official Facebook page.</p>
                                        <div class="d-flex justify-content-end">
                                            <div class="read-more-container">
                                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="news-meta d-flex justify-content-between">
                                        <span><i class="fas fa-calendar-check me-1"></i>2 days ago</span>
                                        <span><i class="fas fa-share-alt me-1"></i>Share</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 news-card-container">
                            <div class="news-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" class="plp-lastest-news" alt="News 1">
                                    <div class="category-tag">Campus News</div>
                                </div>
                                <div class="news-content">
                                    <div class="news-date">
                                        <i class="far fa-calendar-alt me-2"></i>March 15, 2024
                                    </div>  
                                    <div class="meaning">
                                        <h3>Application for Admission, Academic Year 2025-2026</h3>
                                        <p>Admission process for Student-Applicants for AY 2025-26, For Incoming Freshmen Students, Fill-out the Online Application Form that will be posted on January 6, 2025 at the official Facebook page.</p>
                                        <div class="d-flex justify-content-end">
                                            <div class="read-more-container">
                                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="news-meta d-flex justify-content-between">
                                        <span><i class="fas fa-calendar-check me-1"></i>2 days ago</span>
                                        <span><i class="fas fa-share-alt me-1"></i>Share</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 news-card-container">
                            <div class="news-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" class="plp-lastest-news" alt="News 1">
                                    <div class="category-tag">Campus News</div>
                                </div>
                                <div class="news-content">
                                    <div class="news-date">
                                        <i class="far fa-calendar-alt me-2"></i>March 15, 2024
                                    </div>  
                                    <div class="meaning">
                                        <h3>Application for Admission, Academic Year 2025-2026</h3>
                                        <p>Admission process for Student-Applicants for AY 2025-26, For Incoming Freshmen Students, Fill-out the Online Application Form that will be posted on January 6, 2025 at the official Facebook page.</p>
                                        <div class="d-flex justify-content-end">
                                            <div class="read-more-container">
                                                <a href="#" class="read-more">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="news-meta d-flex justify-content-between">
                                        <span><i class="fas fa-calendar-check me-1"></i>2 days ago</span>
                                        <span><i class="fas fa-share-alt me-1"></i>Share</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="see-more news-see-more">
                        <a href="{{ route('newspage') }}" class="see-more-btn">
                            See more <i class="fas fa-angle-double-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row plpevents-content">
                <div class="col-lg-12">
                    <h2 class="section-subtitle mb-4">Upcoming Events</h2>
                    <div class="row plpevents g-4">
                        <div class="col-12 col-sm-6 col-lg-3 events-card-container">
                            <div class="event-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/brigada.jpg') }}" class="plp-latest-events" alt="Event 1">
                                    <div class="category-tag">Academic</div>
                                </div>
                                <div class="news-content">
                                    <h3>Brigada Eskuwela Kick-Off for 2nd Semester</h3>
                                    <div class="event-info">
                                        <span><i class="far fa-calendar-alt me-2"></i>February 3, 2025</span>
                                        <span><i class="fas fa-clock me-2"></i>9:00 AM - 4:00 PM</span>
                                        <span><i class="fas fa-map-marker-alt me-2"></i>Main Campus</span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="learn-more-container">
                                            <a href="events.html" class="learn-more">Learn More <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 events-card-container">
                            <div class="event-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/image4.png') }}" class="plp-latest-events" alt="Event 1">
                                    <div class="category-tag">Academic</div>
                                </div>
                                <div class="news-content">
                                    <h3>Annual Academic Excellence Day</h3>
                                    <div class="event-info">
                                        <span><i class="far fa-calendar-alt me-2"></i>March 15, 2024</span>
                                        <span><i class="fas fa-clock me-2"></i>2:00 PM - 5:00 PM</span>
                                        <span><i class="fas fa-map-marker-alt me-2"></i>Main Auditorium</span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="learn-more-container">
                                            <a href="#" class="learn-more">Learn More <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 events-card-container">
                            <div class="event-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/bg1.jpg') }}" class="plp-latest-events" alt="Event 1">
                                    <div class="category-tag">Academic</div>
                                </div>
                                <div class="news-content">
                                    <h3>Annual Academic Excellence Day</h3>
                                    <div class="event-info">
                                        <span><i class="far fa-calendar-alt me-2"></i>March 15, 2024</span>
                                        <span><i class="fas fa-clock me-2"></i>2:00 PM - 5:00 PM</span>
                                        <span><i class="fas fa-map-marker-alt me-2"></i>Main Auditorium</span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="learn-more-container">
                                            <a href="#" class="learn-more">Learn More <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 events-card-container">
                            <div class="event-card">
                                <div class="card-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/bg1.jpg') }}" class="plp-latest-events" alt="Event 1">
                                    <div class="category-tag">Academic</div>
                                </div>
                                <div class="news-content">
                                    <h3>Annual Academic Excellence Day</h3>
                                    <div class="event-info">
                                        <span><i class="far fa-calendar-alt me-2"></i>March 15, 2024</span>
                                        <span><i class="fas fa-clock me-2"></i>2:00 PM - 5:00 PM</span>
                                        <span><i class="fas fa-map-marker-alt me-2"></i>Main Auditorium</span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="learn-more-container">
                                            <a href="#" class="learn-more">Learn More <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="see-more events-see-more"> 
                        <a href="{{ route('eventspage') }}" class="see-more-btn">
                            See more <i class="fas fa-angle-double-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="awards-section">
        <div class="container awards-section-container">
            <h1 class="awards-section-title">Success Stories</h1>
            <div class="awards-section-content d-flex justify-content-center align-items-center">
                <div class="wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">
                        <li class="card">
                            <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                            <h2 class="m-0">Innovative Leader Award</h2>
                            <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                        <li class="card">
                            <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                            <h2 class="m-0">Innovative Leader Award</h2>
                            <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                        <li class="card">
                            <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                            <h2 class="m-0">Innovative Leader Award</h2>
                            <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                        <li class="card">
                            <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                            <h2 class="m-0">Innovative Leader Award</h2>
                            <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                        <li class="card">
                            <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                            <h2 class="m-0">Innovative Leader Award</h2>
                            <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                        <li class="card">
                          <div class="img"><img src="{{ asset('/assets/img/OpenImages/472435182_611167354757968_3088345316417399531_n.jpg') }}" alt="img" draggable="false"></div>
                          <h2 class="m-0">Innovative Leader Award</h2>
                          <p class="m-0">Honoring individuals who demonstrate creativity, leadership, and groundbreaking solutions, inspiring change through innovation and excellence.</p>
                        </li>
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Add these before closing body tag -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('/assets/js/OpenJS/carousel.js') }}"></script>


</x-open-layout>