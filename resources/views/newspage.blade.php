<x-open-layout>
    @section('title', 'News')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="{{ asset('/assets/css/OpenCSS/news.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/news.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/news.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/line-animation.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scrollreveal-news.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scrollreveal.js') }}"></script>


    <section class="news-n-events-header">
        <img src="{{ asset('/assets/img/OpenImages/PM-pasig1.png') }}" alt="" srcset="" class="img-fluid w-100">
    </section>

  
    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item breadcrumb-one">
                        <a href="/index.html"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-two active" aria-current="page">News</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="news">
        <div class="container">
            <div class="section-header text-center position-relative">
                <h1 class="section-title m-0 text-center">PLP Today: News That Matters</h1>
                <p class="section-subtitle m-0 text-center">Stay informed with the latest happenings at Pamantasan ng Lungsod ng Pasig</p>
            </div>
            
            <div class="categories-section">
                <h2 class="categories-title">Discover University News</h2>
                <div class="categories-container">
                    <a href="#" class="category-filter active">
                        <i class="fas fa-compass"></i>
                        <span class="category-text">Explore All</span>
                        <span class="category-count">32</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-lightbulb"></i>
                        <span class="category-text">Innovation</span>
                        <span class="category-count">8</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-flask"></i>
                        <span class="category-text">Research</span>
                        <span class="category-count">6</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="category-text">Academic</span>
                        <span class="category-count">7</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-trophy"></i>
                        <span class="category-text">Success Stories</span>
                        <span class="category-count">5</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-globe"></i>
                        <span class="category-text">Global Impact</span>
                        <span class="category-count">4</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-users"></i>
                        <span class="category-text">Community</span>
                        <span class="category-count">5</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="category-text">Events</span>
                        <span class="category-count">4</span>
                    </a>
                    <a href="#" class="category-filter">
                        <i class="fas fa-newspaper"></i>
                        <span class="category-text">Press Room</span>
                        <span class="category-count">3</span>
                    </a>
                </div>
            </div>

            <div class="news-grid">
                <!-- Featured News -->
                <div class="news-card featured-news">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="SEAOIL Awards" class="img-fluid">
                        <div class="category-tag">Featured</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">#SEAOIL proudly awards ₱100,000 to ECT board exam topnotcher!</h3>
                        <p class="news-card-text">Engr. Jose Reynaldo Cube, a graduate of the Pamantasan ng Lungsod ng Pasig (PLP) who made it to the Top 3 of the Electronics Technician (ECT) board exams in October 2023, is the first recipient of our Angat Pangarap program.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Regular News Cards -->
                <div class="news-card">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="News Image" class="img-fluid">
                        <div class="category-tag">Academics</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">PLP Launches New Research Center for Sustainable Development</h3>
                        <p class="news-card-text">The university has established a new research center focused on sustainable development and environmental studies.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="News Image" class="img-fluid">
                        <div class="category-tag">Events</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">Annual Research Symposium 2025: Call for Papers</h3>
                        <p class="news-card-text">PLP invites researchers and scholars to submit papers for the upcoming Annual Research Symposium.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="News Image" class="img-fluid">
                        <div class="category-tag">Achievements</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">PLP Students Win National Innovation Competition</h3>
                        <p class="news-card-text">A team of PLP students has won first place in the National Innovation Competition for their sustainable energy solution.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="News Image" class="img-fluid">
                        <div class="category-tag">Partnerships</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">New Industry Partnerships for Student Internships</h3>
                        <p class="news-card-text">PLP has established new partnerships with leading companies to provide internship opportunities for students.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-card-image">
                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="News Image" class="img-fluid">
                        <div class="category-tag">Campus Life</div>
                    </div>
                    <div class="news-card-content">
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>January 3, 2025</span>
                        </div>
                        <h3 class="news-card-title">New Student Center Facilities Now Open</h3>
                        <p class="news-card-text">The newly renovated student center is now open with modern facilities and study spaces.</p>
                        <a href="news-article.html" class="read-more-link">
                            Read More
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav class="pagination-modern">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</x-open-layout>