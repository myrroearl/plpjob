<x-open-layout>
    @section('title', 'Article')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/news.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/news-article.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/ss-newsarticle.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/sr-newsarticle.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>


    <main class="article-main">
        <div class="article-header">
            <div class="container">
                <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item breadcrumb-one">
                            <a href=""><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item breadcrumb-two"><a href="news.html">News</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#SEAOIL proudly awards ₱100,000 to ECT board exam topnotcher!</li>
                    </ol>
                </nav>
                <h1 class="article-title">#SEAOIL proudly awards ₱100,000 to ECT board exam topnotcher!</h1>
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>January 3, 2025</span>
                    </div>
                    <div class="meta-item">
                        <i class="far fa-user"></i>
                        <span>PLP News Staff</span>
                    </div>
                    <div class="meta-item">
                        <i class="far fa-folder"></i>
                        <span>Academic Achievement</span>
                    </div>
                </div>
            </div>
        </div>
      

        <div class="article-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="article-featured-image">
                            <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="SEAOIL Awards Ceremony" class="img-fluid">
                            <div class="image-caption">SEAOIL Philippines CEO presents the award to Engr. Jose Reynaldo Cube</div>
                        </div>
                        
                        <div class="article-text">
                            <p class="lead">In a momentous ceremony held at SEAOIL Philippines headquarters, PLP graduate Engr. Jose Reynaldo Cube was awarded ₱100,000 as recognition for his outstanding achievement in the Electronics Technician (ECT) board exams.</p>
                            
                            <p>Engr. Jose Reynaldo Cube, a graduate of the Pamantasan ng Lungsod ng Pasig (PLP) who made it to the Top 3 of the Electronics Technician (ECT) board exams in October 2023, is the first recipient of SEAOIL's Angat Pangarap program.</p>

                            <h2>A Testament to Excellence</h2>
                            <p>The achievement marks a significant milestone not only for Engr. Cube but also for PLP, demonstrating the institution's commitment to academic excellence and professional development. The Angat Pangarap program, initiated by SEAOIL, aims to recognize and support outstanding achievements of engineering graduates from Philippine universities.</p>

                            <blockquote class="article-quote">
                                "This recognition from SEAOIL is not just a personal achievement but a testament to the quality education provided by PLP. I hope this inspires my fellow students to pursue excellence in their chosen fields."
                                <cite>- Engr. Jose Reynaldo Cube</cite>
                            </blockquote>

                            <h2>Impact on Future Engineers</h2>
                            <p>The recognition comes with more than just monetary reward. SEAOIL has also offered Engr. Cube priority consideration for their engineering positions, opening doors for future career opportunities in one of the Philippines' leading energy companies.</p>

                            <div class="article-highlights">
                                <h3>Key Achievements:</h3>
                                <ul>
                                    <li>Ranked 3rd in the October 2023 ECT Board Exams</li>
                                    <li>First PLP graduate to receive the SEAOIL Angat Pangarap Award</li>
                                    <li>Achieved a board exam rating of 92.45%</li>
                                </ul>
                            </div>
                        </div>

                        <div class="article-tags">
                            <span class="tag-label">Tags:</span>
                            <a href="#" class="tag">Academic Excellence</a>
                            <a href="#" class="tag">Engineering</a>
                            <a href="#" class="tag">Board Exam</a>
                            <a href="#" class="tag">Student Achievement</a>
                        </div>

                        <div class="article-share">
                            <span class="share-label">Share this article:</span>
                            <div class="share-buttons">
                                <a href="#" class="share-button facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="share-button twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="share-button linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="share-button email">
                                    <i class="far fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <aside class="article-sidebar">
                            <div class="sidebar-widget related-news">
                                <h3 class="widget-title">Related News</h3>
                                <div class="related-news-items">
                                    <a href="#" class="related-news-item">
                                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="Related News">
                                        <div class="related-news-content">
                                            <h4>PLP Engineering Department Receives Excellence Award</h4>
                                            <span class="date">December 15, 2024</span>
                                        </div>
                                    </a>
                                    <a href="#" class="related-news-item">
                                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="Related News">
                                        <div class="related-news-content">
                                            <h4>New Engineering Laboratory Opens at PLP</h4>
                                            <span class="date">November 30, 2024</span>
                                        </div>
                                    </a>
                                    <a href="#" class="related-news-item">
                                        <img src="{{ asset('/assets/img/OpenImages/sea-oil.jpg') }}" alt="Related News">
                                        <div class="related-news-content">
                                            <h4>PLP Students Win in National Competition</h4>
                                            <span class="date">November 22, 2024</span>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="sidebar-widget categories">
                                <h3 class="widget-title">News Categories</h3>
                                <ul class="category-list">
                                    <li><a href="#">Academic Achievement <span>(15)</span></a></li>
                                    <li><a href="#">Campus Events <span>(23)</span></a></li>
                                    <li><a href="#">Research & Innovation <span>(8)</span></a></li>
                                    <li><a href="#">Student Life <span>(12)</span></a></li>
                                    <li><a href="#">Faculty News <span>(9)</span></a></li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>

</x-open-layout>