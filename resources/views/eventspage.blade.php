<x-open-layout>
    @section('title', 'Events')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="{{ asset('/assets/css/OpenCSS/events.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/events.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/custom.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/calendar.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/sr-events.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-animate.js') }}"></script>

    <section class="news-n-events-header">
        <img src="{{ asset('/assets/img/OpenImages/PM-pasig1.png') }}" alt="" srcset="" class="img-fluid">
    </section>

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item breadcrumb-one">
                        <a href="/index.html"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-two active" aria-current="page">Events</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="events pt-5 pb-5">
        <div class="container-fluid">
            <div class="events-header-container">
                <h1 class="mb-4 fst-italic events-header">Don't Miss Out: PLP Events</h1>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="wrapper calendar-wrapper">
                        <header>
                            <p class="current-date m-0"></p>
                            <div class="icons">
                                <span id="prev" class="material-symbols-rounded d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-arrow-left text-success" style="font-size: 20px;"></i>
                                </span>
                                <span id="next" class="material-symbols-rounded d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-arrow-right text-success" style="font-size: 20px;"></i>
                                </span>
                            </div>
                        </header>
                        <hr>
                        <div class="calendar">
                            <ul class="weeks p-0">
                                <li>Sun</li>
                                <li>Mon</li>
                                <li>Tue</li>
                                <li>Wed</li>
                                <li>Thu</li>
                                <li>Fri</li>
                                <li>Sat</li>
                            </ul>
                            <ul class="days p-0"></ul>
                        </div>
                    </div>
                    <div class="event-search mb-4 sabay">
                        <form class="d-flex" role="search">
                            <i class="fas fa-search search-icon"></i>
                            <input class="form-control" type="search" placeholder="Search event..." aria-label="Search">
                            
                        </form>
                    </div>
                    <div class="categories mb-4 sabay">
                        <div class="categories-container">
                            <div class="header">
                                <p class="m-0">FILTER EVENTS</p>
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div class="categories-list">
                                <div class="filter-group">
                                    <h6 class="filter-group-title">Event Type</h6>
                                    <div class="filter-options">
                                        <div class="filter-option">
                                            <input type="checkbox" id="academic" name="type" value="academic">
                                            <label for="academic">Academic Calendar</label>
                                            <span class="filter-count">(12)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="community" name="type" value="community">
                                            <label for="community">Community Events</label>
                                            <span class="filter-count">(8)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="cultural" name="type" value="cultural">
                                            <label for="cultural">Cultural Events</label>
                                            <span class="filter-count">(5)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="sports" name="type" value="sports">
                                            <label for="sports">Sports Events</label>
                                            <span class="filter-count">(3)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-group">
                                    <h6 class="filter-group-title">Department</h6>
                                    <div class="filter-options">
                                        <div class="filter-option">
                                            <input type="checkbox" id="student-affairs" name="department" value="student-affairs">
                                            <label for="student-affairs">Student Affairs</label>
                                            <span class="filter-count">(15)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="academics" name="department" value="academics">
                                            <label for="academics">Academics</label>
                                            <span class="filter-count">(10)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="research" name="department" value="research">
                                            <label for="research">Research & Extension</label>
                                            <span class="filter-count">(7)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-group">
                                    <h6 class="filter-group-title">Time Period</h6>
                                    <div class="filter-options">
                                        <div class="filter-option">
                                            <input type="checkbox" id="upcoming" name="period" value="upcoming">
                                            <label for="upcoming">Upcoming</label>
                                            <span class="filter-count">(20)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="ongoing" name="period" value="ongoing">
                                            <label for="ongoing">Ongoing</label>
                                            <span class="filter-count">(3)</span>
                                        </div>
                                        <div class="filter-option">
                                            <input type="checkbox" id="past" name="period" value="past">
                                            <label for="past">Past Events</label>
                                            <span class="filter-count">(45)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="col-lg-8 events-removal">   
                    <div class="row events-container">
                        <!-- Regular Event Card View -->
                        <div class="col-xl-4 mb-4 event-wrapper">
                            <div class="event-card" onclick="showEventDetails(this)" data-event-id="1">
                                <div class="event-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/brigada.jpg') }}" alt="Brigada Eskuwela" class="img-fluid">
                                    <div class="category-tag">
                                        <p class="m-0 day">03</p>
                                        <p class="m-0 month">Feb 2025</p>
                                    </div>
                                    <div class="event-status status-upcoming">Upcoming</div>
                                </div>
                                <div class="event-content">
                                    <span class="event-department">Student Affairs</span>
                                    <h3 class="header fw-bolder h5 mb-0">Brigada Eskuwela Kick-Off for 2nd Semester</h3>
                                    <div class="event-meta">
                                        <div><i class="far fa-clock"></i> 9:00 AM - 4:00 PM</div>
                                        <div><i class="fas fa-map-marker-alt"></i> Main Campus</div>
                                    </div>
                                    <p class="m-0">Going back to campus feels extra special when it is not just familiar—it is greener and cleaner! Join us for another impactful edition of Brigada Eskuwela!</p>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Additional Event Cards -->
                        <div class="col-xl-4 mb-4 event-wrapper">
                            <div class="event-card" onclick="showEventDetails(this)" data-event-id="2">
                                <!-- Similar structure for other events -->
                                <div class="event-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/brigada.jpg') }}" alt="Research Symposium" class="img-fluid">
                                    <div class="category-tag">
                                        <p class="m-0 day">15</p>
                                        <p class="m-0 month">Feb 2025</p>
                                    </div>
                                    <div class="event-status status-upcoming">Upcoming</div>
                                </div>
                                <div class="event-content">
                                    <span class="event-department">Research & Development</span>
                                    <h3 class="header fw-bolder h5 mb-0">Annual Research Symposium 2025</h3>
                                    <div class="event-meta">
                                        <div><i class="far fa-clock"></i> 8:00 AM - 5:00 PM</div>
                                        <div><i class="fas fa-map-marker-alt"></i> PLP Auditorium</div>
                                    </div>
                                    <p class="m-0">Join us for a day of scholarly presentations and discussions featuring groundbreaking research from our faculty and students.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 mb-4 event-wrapper">
                            <div class="event-card" onclick="showEventDetails(this)" data-event-id="3">
                                <!-- Similar structure for other events -->
                                <div class="event-image-wrapper">
                                    <img src="{{ asset('/assets/img/OpenImages/brigada.jpg') }}" alt="Research Symposium" class="img-fluid">
                                    <div class="category-tag">
                                        <p class="m-0 day">15</p>
                                        <p class="m-0 month">Feb 2025</p>
                                    </div>
                                    <div class="event-status status-upcoming">Upcoming</div>
                                </div>
                                <div class="event-content">
                                    <span class="event-department">Research & Development</span>
                                    <h3 class="header fw-bolder h5 mb-0">Annual Research Symposium 2025</h3>
                                    <div class="event-meta">
                                        <div><i class="far fa-clock"></i> 8:00 AM - 5:00 PM</div>
                                        <div><i class="fas fa-map-marker-alt"></i> PLP Auditorium</div>
                                    </div>
                                    <p class="m-0">Join us for a day of scholarly presentations and discussions featuring groundbreaking research from our faculty and students.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add more event cards as needed -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</x-open-layout>