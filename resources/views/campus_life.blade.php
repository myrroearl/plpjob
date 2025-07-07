<x-open-layout>
    @section('title', 'Campus Life')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="{{ asset('assets/css/OpenCSS/campuslife.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset( 'assets/css/OpenCSS/campuslife.css') }}">
    <link rel="stylesheet" href="{{ asset( 'assets/css/OpenCSS/custom.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="{{ asset('assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/campuslife.js') }}"></script>

    <!-- Main Content Goes Here -->
    <section class="campus-life-header">
        <img src="{{ asset('assets/img/OpenImages/PM-pasig1.png') }}" alt="Campus Life" class="img-fluid w-100">
    </section>

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Campus Life</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Campus Life Content Section -->
    <section class="campus-life-content py-5">
        <div class="container">
            <div class="hero-section text-center mb-5" data-aos="fade-up">
                <span class="subtitle mb-3 d-block">COLLABORATING AND INNOVATING</span>
                <h1 class="display-4 fw-bold mb-4">From the moment you choose PLP</h1>
                <p class="lead mb-5">You join more than 10,000 members of the PLP family — students, faculty, staff and alumni — representing our institution with pride.</p>
                <div class="hero-description">
                    <p class="text-muted">We are a diverse community of scholars who work, teach and engage in every corner of Pasig City. Collectively we're focused on creating knowledge for the public good, an ideal rooted in our identity as a premier public university in Pasig. We don't just identify problems; we work to find and test solutions to our community's greatest challenges.</p>
                </div>
            </div>

            <div class="quick-links mb-5" data-aos="fade-up">
                <div class="row justify-content-center g-3">
                    <div class="col-md-2 col-6">
                        <a href="#athletics" class="quick-link-item">
                            <i class="fas fa-running"></i>
                            <span>Athletics & Recreation</span>
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="#arts" class="quick-link-item">
                            <i class="fas fa-palette"></i>
                            <span>Arts & Culture</span>
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="#health" class="quick-link-item">
                            <i class="fas fa-heartbeat"></i>
                            <span>Health & Safety</span>
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="#living" class="quick-link-item">
                            <i class="fas fa-home"></i>
                            <span>Live, Work, Travel</span>
                        </a>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="#student" class="quick-link-item">
                            <i class="fas fa-users"></i>
                            <span>Student Life</span>
                        </a>
                    </div>
                </div>
            </div>


            <div class="featured-section mb-5">
                <div class="featured-grid">
                    <div class="featured-item main-feature" data-aos="fade-up">
                        <div class="card-overlay"></div>
                        <img src="{{ asset('assets/img/OpenImages/PM-pasig1.png') }}" alt="Campus Life" class="img-fluid">
                        <div class="card-content">
                            <div class="badge-container">
                                <span class="badge bg-gradient">FEATURED</span>
                                <span class="badge bg-light text-dark">INTERACTIVE</span>
                            </div>
                            <h2>Discover PLP Life</h2>
                            <p>Experience the vibrant campus culture and academic excellence that defines the Pamantasan ng Lungsod ng Pasig community.</p>
                            <div class="btn-group">
                                <a href="#" class="btn btn-light btn-glow">Take the Tour</a>
                                <a href="#" class="btn btn-outline-light">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <div class="featured-item secondary-feature" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-overlay gradient-overlay-1"></div>
                        <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Academic Excellence" class="img-fluid">
                        <div class="card-content">
                            <span class="badge bg-primary">ACADEMICS</span>
                            <h3>Academic Excellence</h3>
                            <p>Discover our world-class programs and dedicated faculty.</p>
                            <a href="#" class="link-arrow">Explore Programs <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="featured-item secondary-feature" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-overlay gradient-overlay-2"></div>
                        <img src="{{ asset('assets/img/OpenImages/mission.png') }}" alt="Student Life" class="img-fluid">
                        <div class="card-content">
                            <span class="badge bg-success">CAMPUS LIFE</span>
                            <h3>Student Life</h3>
                            <p>Join a community that supports your growth and success.</p>
                            <a href="#" class="link-arrow">Get Involved <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="featured-item secondary-feature" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-overlay gradient-overlay-3"></div>
                        <img src="{{ asset('assets/img/OpenImages/vission.png') }}" alt="Research & Innovation" class="img-fluid">
                        <div class="card-content">
                            <span class="badge bg-warning">RESEARCH</span>
                            <h3>Research & Innovation</h3>
                            <p>Be part of groundbreaking research and innovation.</p>
                            <a href="#" class="link-arrow">Discover Research <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="featured-item secondary-feature" data-aos="fade-up" data-aos-delay="400">
                        <div class="card-overlay gradient-overlay-4"></div>
                        <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Community Engagement" class="img-fluid">
                        <div class="card-content">
                            <span class="badge bg-info">COMMUNITY</span>
                            <h3>Community Engagement</h3>
                            <p>Make an impact through service and outreach programs.</p>
                            <a href="#" class="link-arrow">Get Involved <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                
            Sports & Athletics Section
            <div class="sports-section mb-5" data-aos="fade-up">
                <h2 class="text-center mb-4">Sports & Athletics</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="sport-card">
                            <div class="sport-image-container">
                                <img src="{{ asset('assets/img/OpenImages/varsity.jpg') }}" alt="Basketball Team" class="img-fluid rounded">
                                <div class="sport-overlay gradient-overlay-1"></div>
                            </div>
                            <div class="sport-content">
                                <h3>Varsity Teams</h3>
                                <p>Join our competitive varsity teams and represent PLP in various sports competitions. We offer training in basketball, volleyball, badminton, and more.</p>
                                <a href="#" class="btn btn-primary">View Teams</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sport-card">
                            <div class="sport-image-container">
                                <img src="{{ asset('assets/img/OpenImages/court.jpg') }}" alt="Fitness Center" class="img-fluid rounded">
                                <div class="sport-overlay gradient-overlay-2"></div>
                            </div>
                            <div class="sport-content">
                                <h3>Fitness & Recreation</h3>
                                <p>Stay active with our state-of-the-art fitness center, swimming pool, and various recreational facilities available to all students.</p>
                                <a href="#" class="btn btn-primary">Explore Facilities</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sport-card">
                            <div class="sport-image-container">
                                <img src="{{ asset('assets/img/OpenImages/sport1.jpg') }}" alt="Intramurals" class="img-fluid rounded">
                                <div class="sport-overlay gradient-overlay-3"></div>
                            </div>
                            <div class="sport-content">
                                <h3>Intramural Sports</h3>
                                <p>Participate in our intramural sports program featuring friendly competitions and tournaments throughout the academic year.</p>
                                <a href="#" class="btn btn-primary">Join Intramurals</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sport-card">
                            <div class="sport-image-container">
                                <img src="{{ asset('assets/img/OpenImages/sportss.jpg') }}" alt="Sports Events" class="img-fluid rounded">
                                <div class="sport-overlay gradient-overlay-4"></div>
                            </div>
                            <div class="sport-content">
                                <h3>Sports Events</h3>
                                <p>Experience exciting sports events, including annual tournaments, sports festivals, and special competitions.</p>
                                <a href="#" class="btn btn-primary">View Events</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="quick-stats" data-aos="fade-up">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h4>10,000+</h4>
                            <p>Students</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <h4>50+</h4>
                            <p>Programs</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="stat-content">
                            <h4>90%</h4>
                            <p>Employment Rate</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="stat-content">
                            <h4>100+</h4>
                            <p>Partner Organizations</p>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <!-- Photo Gallery -->
            <div class="photo-gallery mb-5 mt-5" data-aos="fade-up">
                <h2 class="text-center mb-4">Campus Life in Pictures</h2>
                <div class="gallery-container">
                    <div class="gallery-scroll">
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/mission.png') }}" alt="Student Organization Fair" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Student Organization Fair</h4>
                                    <p>Annual showcase of student clubs and organizations where students can explore opportunities to get involved on campus.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Sports Tournament" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Sports Tournament</h4>
                                    <p>Intramural sports competitions bring students together for friendly competition and team building activities.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/vission.png') }}" alt="Cultural Festival" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Cultural Festival</h4>
                                    <p>Celebration of diverse cultures through music, dance, food, and art, promoting understanding and appreciation.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/vission.png') }}" alt="Health & Wellness Fair" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Health & Wellness Fair</h4>
                                    <p>Resources and activities focused on promoting physical and mental well-being among students.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/mission.png') }}" alt="Leadership Workshop" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Leadership Workshop</h4>
                                    <p>Training sessions designed to develop student leadership skills and prepare future community leaders.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/vission.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/mission.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/core.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/mission.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-item">
                            <img src="{{ asset('assets/img/OpenImages/vission.png') }}" alt="Diversity Celebration" class="img-fluid rounded">
                            <div class="gallery-overlay">
                                <div class="gallery-caption">
                                    <h4>Diversity Celebration</h4>
                                    <p>Events that highlight and celebrate the rich diversity of our student body and promote inclusion.</p>
                                    <a href="#" class="btn btn-sm btn-light">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-controls">
                    <button class="gallery-nav prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
                    <button class="gallery-nav next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            
            <!-- Testimonials -->
            <div class="testimonials-section mb-5" data-aos="fade-up">
                <h2 class="text-center mb-4">Student Testimonials</h2>
                <div class="testimonials-slider">
                    <div class="testimonials-track">
                        <div class="testimonial-card p-4">
                            <div class="testimonial-content mb-3">
                                <p class="fst-italic">"The vibrant campus life at PLP has enriched my college experience beyond academics. I've developed leadership skills and made lifelong friends through student organizations."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <img src="{{ asset('assets/img/OpenImages/zel.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h5 class="mb-0">Renzel Lagasca</h5>
                                    <p class="mb-0 text-muted">BS Information Technology, Class of 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-card p-4">
                            <div class="testimonial-content mb-3">
                                <p class="fst-italic">"The health and wellness resources at PLP have been invaluable to my academic success. The counseling services helped me manage stress, and the fitness center keeps me active and energized."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <img src="{{ asset('assets/img/OpenImages/myrro.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h5 class="mb-0">Myrro Earl Milleza</h5>
                                    <p class="mb-0 text-muted">BS Information Technology, Class of 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-card p-4">
                            <div class="testimonial-content mb-3">
                                <p class="fst-italic">"As an international student, I was worried about fitting in, but PLP's diversity and inclusion programs made me feel welcome from day one. The multicultural initiatives have enriched my perspective."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <img src="{{ asset('assets/img/OpenImages/vincent.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h5 class="mb-0">Vincent Lawrence Enriquez</h5>
                                    <p class="mb-0 text-muted">BS Information Technology, Class of 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-card p-4">
                            <div class="testimonial-content mb-3">
                                <p class="fst-italic">"As an international student, I was worried about fitting in, but PLP's diversity and inclusion programs made me feel welcome from day one. The multicultural initiatives have enriched my perspective."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <img src="{{ asset('assets/img/OpenImages/lebron.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h5 class="mb-0">Lebron James</h5>
                                    <p class="mb-0 text-muted">BS Education, Class of 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-card p-4">
                            <div class="testimonial-content mb-3">
                                <p class="fst-italic">"As an international student, I was worried about fitting in, but PLP's diversity and inclusion programs made me feel welcome from day one. The multicultural initiatives have enriched my perspective."</p>
                            </div>
                            <div class="testimonial-author d-flex align-items-center">
                                <img src="{{ asset('assets/img/OpenImages/luka.jpg') }}" alt="Student" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h5 class="mb-0">Luka Doncic</h5>
                                    <p class="mb-0 text-muted">BS Business Administration, Class of 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-controls">
                        <div class="testimonial-dots"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="{{ asset('assets/js/OpenJS/campuslife.js') }}"></script>

</x-open-layout>