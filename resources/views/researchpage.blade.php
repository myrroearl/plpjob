<x-open-layout>
    @section('title', 'Article')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="{{ asset('/assets/css/OpenCSS/research.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/research.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/custom.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/research.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/sr-research.js') }}"></script>

    <section class="news-n-events-header">
        <img src="{{ asset('/assets/img/OpenImages/PM-pasig1.png') }}" alt="" srcset="" class="img-fluid w-100">
    </section>

  
    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '|';">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item breadcrumb-one"><a href="/"><i class="fas fa-home"></i> Home</a></li>
                
                    <li class="breadcrumb-item breadcrumb-two active" aria-current="page">Research</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Research & Extension Navigation -->
    <nav class="navbar navbar-expand-lg research-nav sticky-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#researchNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="researchNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#research-office">Research Office</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#community-extension">Community Extension</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#research-workflow">Research & Workflow</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#events-reservation">Events & Reservation</a>
                    </li>
                </ul>
            </div>  
        </div>
    </nav>

    <!-- Research Office Section -->
    <section id="research-office" class="py-5">
        <div class="container">
                <div class="section-header text-center mb-5">
                <h2 class="section-title">Research Office</h2>
                <p class="section-subtitle">Advancing Knowledge Through Research</p>
                </div>
                
                <div class="row g-4">
                <div class="col-md-6">
                    <div class="research-card">
                        <div class="card-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Philosophy</h3>
                        <p>We believe in the transformative power of research to drive innovation and create positive change in society.</p>
                                </div>
                            </div>
                <div class="col-md-6">
                    <div class="research-card">
                        <div class="card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Mission</h3>
                        <p>To foster a culture of research excellence and innovation that contributes to the advancement of knowledge and societal development.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="research-card">
                                    <div class="card-icon">
                            <i class="fas fa-eye"></i>
                                    </div>
                        <h3>Vision</h3>
                        <p>To be a leading research institution recognized for its significant contributions to academic excellence and community development.</p>
                                    </div>
                                </div>
                <div class="col-md-6">
                    <div class="research-card">
                                    <div class="card-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Objectives</h3>
                        <ul>
                            <li>Promote research excellence across all disciplines</li>
                            <li>Foster interdisciplinary collaboration</li>
                            <li>Support faculty and student research initiatives</li>
                            <li>Facilitate knowledge transfer and innovation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Extension Section -->
    <section id="community-extension" class="py-5 bg-light">
        <div class="container">
                <div class="section-header text-center mb-5">
                <h2 class="section-title">Community Extension Service Office</h2>
                <p class="section-subtitle">Serving Communities Through Extension</p>
                </div>

                <div class="row g-4">
                <div class="col-md-6">
                    <div class="extension-card">
                        <div class="card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Mission</h3>
                        <p>To extend the university's resources and expertise to communities, fostering sustainable development and social transformation.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="extension-card">
                        <div class="card-icon">
                            <i class="fas fa-eye"></i>
                                    </div>
                        <h3>Vision</h3>
                        <p>To be a catalyst for positive change in communities through meaningful extension services and partnerships.</p>
                                    </div>
                                </div>
                <div class="col-md-6">
                    <div class="extension-card">
                        <div class="card-icon">
                            <i class="fas fa-flag"></i>
                                    </div>
                        <h3>Goals</h3>
                        <ul>
                            <li>Enhance community engagement</li>
                            <li>Promote sustainable development</li>
                            <li>Build strong community partnerships</li>
                            <li>Empower communities through education</li>
                        </ul>
                                    </div>
                                </div>
                <div class="col-md-6">
                    <div class="extension-card">
                        <div class="card-icon">
                            <i class="fas fa-tasks"></i>
                                    </div>
                        <h3>Objectives</h3>
                        <ul>
                            <li>Develop and implement community programs</li>
                            <li>Provide technical assistance and training</li>
                            <li>Conduct needs assessment and evaluation</li>
                            <li>Facilitate community capacity building</li>
                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
    </section>

    <!-- Research & Workflow Section -->
    <section id="research-workflow" class="py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Research Office</h2>
                <p class="section-subtitle">Workflow Of General Transactions</p>
            </div>
            
            <!-- Simple Workflow Overview -->
            <div class="row mb-5">
                <div class="col-lg-6 mb-4">
                    <h3 class="workflow-title">I. Steps for the university-based or office-based</h3>
                    <ul class="workflow-steps-list">
                        <li>RESEARCH PROPOSAL</li>
                        <li>RESEARCH PROPOSAL</li>
                        <li>APPROVAL OF THE PRESIDENT</li>
                        <li>APPROVAL OF THE MAYOR</li>
                        <li>BUDGET</li>
                        <li>ACCOUNTING</li>
                        <li>HUMAN RESOURCES</li>
                    </ul>
                </div>
                
                <div class="col-lg-6">
                    <h3 class="workflow-title">II. Steps for the college-based research proposal</h3>
                    <ul class="workflow-steps-list">
                        <li>RESEARCH PROPOSAL</li>
                        <li>RECOMMENDING APPROVAL OF THE DEAN AND ENDORSEMENT OF THE RESEARCH DIRECTOR</li>
                        <li>APPROVAL OF THE PRESIDENT</li>
                        <li>APPROVAL OF THE MAYOR</li>
                        <li>BUDGET</li>
                        <li>ACCOUNTING</li>
                        <li>HUMAN RESOURCES</li>
                    </ul>
                </div>
            </div>
            
            <hr class="mb-5">
            
            <div class="section-header text-center mb-5">
                <h2 class="section-title">WORK INSTRUCTIONS OF THE UNIVERSITY RESEARCH OFFICE</h2>
            </div>
            
            <div class="row">
                <!-- Faculty Research Proposal Endorsement -->
                <div class="col-12 mb-5">
            <div class="workflow-container">
                        <h3 class="workflow-title">I. Title: Faculty Research Proposal Endorsement</h3>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">1.0. Objective:</h4>
                            <p>To ensure that Faculty Research Proposals are endorsed to the President's Office within one (1) day from the time the document was received.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">2.0. Scope:</h4>
                            <p>This shall apply to all faculty members who would like to conduct research.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">3.0. Procedure:</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Process Flow</th>
                                            <th width="30%">Responsibility</th>
                                            <th width="40%">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="3" class="align-middle">
                                                <img src="{{ asset('/assets/img/OpenImages/1.png') }}" alt="Process Flow Diagram" class="img-fluid">
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director / Secretary / SA</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Receive the research proposal from faculty members.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Assess the research proposal and make recommendations for improvement.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Endorse the research proposal to the President for approval.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">4.0. Reference Documents / Records:</h4>
                            <p>________Research Manual</p>
                            <p>________Daily Transaction Log Book</p>
                        </div>
                    </div>
                </div>
                
                <!-- External Research Proposal Endorsement -->
                <div class="col-12 mb-5">
                    <div class="workflow-container">
                        <h3 class="workflow-title">II. Title: External Research Proposal Endorsement</h3>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">1.0. Objective:</h4>
                            <p>To ensure that External Research Proposals are endorsed to the President's Office within one (1) day from the time the document was received.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">2.0. Scope:</h4>
                            <p>This shall apply to all researchers from other institutions or organizations who would like to conduct research at the Pamantasan ng Lungsod ng Pasig.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">3.0. Procedure:</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Process Flow</th>
                                            <th width="30%">Responsibility</th>
                                            <th width="40%">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="3" class="align-middle">
                                                <img src="{{ asset('/assets/img/OpenImages/2.png') }}" alt="Process Flow Diagram" class="img-fluid">
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director / Secretary / SA</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Receive the research proposal from external researchers.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Assess the research proposal and make recommendations to the President.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Endorse the research proposal to the President for approval.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">4.0. Reference Documents/Records:</h4>
                            <p>________Research Manual</p>
                            <p>________Daily Transaction Log Book</p>
                        </div>
                    </div>
                </div>
                
                <!-- Student Research Proposal Endorsement -->
                <div class="col-12 mb-5">
                    <div class="workflow-container">
                        <h3 class="workflow-title">III. Title: Student Research Proposal Endorsement</h3>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">1.0. Objective:</h4>
                            <p>To ensure that the Student Research Proposals are endorsed to the President's Office within one (1) day from the time the document was received.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">2.0. Scope:</h4>
                            <p>This shall apply to all PLP students who would like to conduct researches in PLP.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">3.0. Procedure:</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Process Flow</th>
                                            <th width="30%">Responsibility</th>
                                            <th width="40%">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="3" class="align-middle">
                                                <img src="{{ asset('/assets/img/OpenImages/3.png') }}" alt="Process Flow Diagram" class="img-fluid">
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director / Secretary / SA</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Receive the research proposal from external researchers.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Assess the research proposal and make recommendations to the President.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Endorse the research proposal to the President for approval.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">4.0. Reference Documents/Records:</h4>
                            <p>________Research Manual</p>
                            <p>________Daily Transaction Log Book</p>
                        </div>
                    </div>
                </div>
                
                <!-- Approval of Semester Loading -->
                <div class="col-12">
                    <div class="workflow-container">
                        <h3 class="workflow-title">IV. Title: Approval of Semester Loading of Faculty Members Teaching Research Subjects</h3>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">1.0. Objective:</h4>
                            <p>To ensure that the Semester Loading of Faculty Members tasked to teach research subjects are reviewed and signed within one (1) day from the time the document was received.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">2.0. Scope:</h4>
                            <p>This shall apply to all faculty members who are tasked to teach any research subjects.</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">3.0. Procedure:</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Process Flow</th>
                                            <th width="30%">Responsibility</th>
                                            <th width="40%">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="4" class="align-middle">
                                                <img src="{{ asset('/assets/img/OpenImages/4.png') }}" alt="Faculty Loading Process Flow" class="img-fluid">
                                            </td>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director / Secretary / SA</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Receive the faculty loading.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>Ensure that the faculty's credentials have met the qualifications set by the University Manual in order to teach any research subject.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>The Research Director will sign the faculty loading.</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <ul class="list-unstyled">
                                                    <li>Research Director</li>
                                                </ul>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="fw-bold">4.0. Reference Documents/Records:</h4>
                            <p>________Research Manual</p>
                            <p>________Daily Transaction Log Book</p>
                        </div>
                    </div>
                                    </div>
                                </div>
                                    </div>
    </section>

    <!-- Events & Reservation Section -->
    <section id="events-reservation" class="py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Events Calendar</h2>
                <p class="section-subtitle">Research and Academic Events</p>
            </div>
            
            <div class="calendar-wrapper">
                <!-- Calendar Header -->
                <div class="calendar-header">
                    <div class="month-navigation">
                        <button class="month-nav-btn prev"><i class="fas fa-chevron-left"></i></button>
                        <div class="month-selector">
                            <h3 class="current-month" id="currentMonth">APRIL 2025</h3>
                            <div class="month-dropdown" id="monthDropdown">
                                <div class="month-option" data-month="0">JANUARY</div>
                                <div class="month-option" data-month="1">FEBRUARY</div>
                                <div class="month-option" data-month="2">MARCH</div>
                                <div class="month-option" data-month="3">APRIL</div>
                                <div class="month-option" data-month="4">MAY</div>
                                <div class="month-option" data-month="5">JUNE</div>
                                <div class="month-option" data-month="6">JULY</div>
                                <div class="month-option" data-month="7">AUGUST</div>
                                <div class="month-option" data-month="8">SEPTEMBER</div>
                                <div class="month-option" data-month="9">OCTOBER</div>
                                <div class="month-option" data-month="10">NOVEMBER</div>
                                <div class="month-option" data-month="11">DECEMBER</div>
                            </div>
                        </div>
                        <button class="month-nav-btn next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                
                <div class="calendar-container">
                    <!-- Left Side - Events List -->
                    <div class="events-sidebar">
                        <!-- Event Item 1 -->
                        <div class="calendar-event-item" data-day="5">
                            <div class="event-date">
                                <span class="event-day">05</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">STUDENT ART FAIR <span class="event-time">10AM - 4PM</span></h4>
                                <p class="event-desc">Join us for showcasing new talent & skills at PLP Campus Student Art Exhibition. All are welcome to attend and show support.</p>
                            </div>
                        </div>
                        
                        <!-- Event Item 2 -->
                        <div class="calendar-event-item" data-day="7">
                            <div class="event-date">
                                <span class="event-day">07</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">MOVIE NIGHT: THE GRADUAL THEORY <span class="event-time">5:00PM</span></h4>
                                <p class="event-desc">We all know the film, but it's awesome and it's shockingly fun to talk about it during viewing. Come over and chat!</p>
                            </div>
                        </div>
                        
                        <!-- Event Item 3 -->
                        <div class="calendar-event-item" data-day="14">
                            <div class="event-date">
                                <span class="event-day">14</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">SEMESTER 1 WRAP UP <span class="event-time">10AM</span></h4>
                                <p class="event-desc">We'll have a free time where we can do the bit we need to discuss with your pals. Open on WED 14th.</p>
                            </div>
                        </div>
                        
                        <!-- Event Item 4 -->
                        <div class="calendar-event-item" data-day="21">
                            <div class="event-date">
                                <span class="event-day">21</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">TIME TO CONSOLIDATE <span class="event-time">9AM</span></h4>
                                <p class="event-desc">Professors solving forms, grad protocol and admin matters are happening today. Please secure your documents.</p>
                            </div>
                        </div>
                        
                        <!-- Event Item 5 -->
                        <div class="calendar-event-item" data-day="24">
                            <div class="event-date">
                                <span class="event-day">24</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">RESEARCH SYMPOSIUM <span class="event-time">10AM - 3PM</span></h4>
                                <p class="event-desc">Annual Research Symposium featuring student and faculty research presentations and posters.</p>
                            </div>
                        </div>
                        
                        <!-- Event Item 6 -->
                        <div class="calendar-event-item" data-day="31">
                            <div class="event-date">
                                <span class="event-day">31</span>
                                <span class="event-month">MAY</span>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title">FINAL YEAR MEETING <span class="event-time">10AM</span></h4>
                                <p class="event-desc">We'll have a free time where we can do the bit we need to discuss with your pals.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Calendar Grid -->
                    <div class="calendar-grid">
                        <!-- Calendar Days Header -->
                        <div class="calendar-days-header">
                            <div class="calendar-day-name">MON</div>
                            <div class="calendar-day-name">TUE</div>
                            <div class="calendar-day-name">WED</div>
                            <div class="calendar-day-name">THU</div>
                            <div class="calendar-day-name">FRI</div>
                            <div class="calendar-day-name">SAT</div>
                            <div class="calendar-day-name">SUN</div>
                        </div>
                        
                        <!-- Calendar Days Grid -->
                        <div class="calendar-days-grid">
                            <!-- Week 1 -->
                            <div class="calendar-day prev-month">27</div>
                            <div class="calendar-day prev-month">28</div>
                            <div class="calendar-day prev-month">29</div>
                            <div class="calendar-day prev-month">30</div>
                            <div class="calendar-day">1</div>
                            <div class="calendar-day highlight">2</div>
                            <div class="calendar-day">3</div>
                            
                            <!-- Week 2 -->
                            <div class="calendar-day">4</div>
                            <div class="calendar-day has-event highlight" data-day="5">5</div>
                            <div class="calendar-day">6</div>
                            <div class="calendar-day has-event" data-day="7">7</div>
                            <div class="calendar-day">8</div>
                            <div class="calendar-day">9</div>
                            <div class="calendar-day">10</div>
                            
                            <!-- Week 3 -->
                            <div class="calendar-day">11</div>
                            <div class="calendar-day">12</div>
                            <div class="calendar-day">13</div>
                            <div class="calendar-day has-event highlight" data-day="14">14</div>
                            <div class="calendar-day">15</div>
                            <div class="calendar-day">16</div>
                            <div class="calendar-day">17</div>
                            
                            <!-- Week 4 -->
                            <div class="calendar-day">18</div>
                            <div class="calendar-day">19</div>
                            <div class="calendar-day">20</div>
                            <div class="calendar-day has-event highlight" data-day="21">21</div>
                            <div class="calendar-day">22</div>
                            <div class="calendar-day">23</div>
                            <div class="calendar-day has-event highlight" data-day="24">24</div>
                            
                            <!-- Week 5 -->
                            <div class="calendar-day">25</div>
                            <div class="calendar-day">26</div>
                            <div class="calendar-day">27</div>
                            <div class="calendar-day">28</div>
                            <div class="calendar-day">29</div>
                            <div class="calendar-day">30</div>
                            <div class="calendar-day has-event" data-day="31">31</div>
                        </div>
                        
                        <!-- Day Event Popup -->
                        <div class="day-event-popup">
                            <button class="day-event-popup-close"><i class="fas fa-times"></i></button>
                            <div class="day-event-popup-date"></div>
                            <div class="day-event-popup-title"></div>
                            <div class="day-event-popup-time"></div>
                            <div class="day-event-popup-desc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-open-layout>