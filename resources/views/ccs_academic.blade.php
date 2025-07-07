<x-open-layout>
    @section('title', 'Computer Studies')

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preload" href="{{ asset('assets/css/OpenCSS/colleges.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/colleges.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/ccs.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script defer src="{{ asset('assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/sr-colleges.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/line-animation.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/scrollreveal.js') }}"></script>

    <section class="college-header">
        <div class="header-image">
            <img src="{{ asset('assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Computer Studies" class="img-fluid w-100">
            <div class="header-overlay">
                <h1>College of Computer Studies</h1>
                <p>Innovating Tomorrow's Technology Today</p>
            </div>
        </div>
    </section>

    <!-- Breadcrumb Navigation -->
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="colleges.html">Academics</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">College of Computer Studies</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="college-content">  
        <div class="container py-5">
            <!-- Overview Section -->
            <section class="college-overview mb-3">
                <h2 class="section-title">Overview</h2>
                <p class="lead">The College of Computer Studies (CCS) at Pamantasan ng Lungsod ng Pasig is dedicated to producing competent and innovative IT professionals equipped with the latest technological skills and knowledge.</p>
                <div class="row mt-4">
                    <div class="col-md-6 text-center mb-4 overview-card-container">
                        <div class="overview-card">
                            <i class="fas fa-rocket"></i>
                            <h3>Our Mission</h3>
                            <p>To provide quality education in computer science and information technology, fostering innovation and technological advancement while serving the community.</p>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-4 overview-card-container-one">
                        <div class="overview-card">
                            <i class="fas fa-eye"></i>
                            <h3>Our Vision</h3>
                            <p>To be a leading institution in computer education, research, and technological innovation in the Philippines.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Programs Section -->
            <section class="programs-section mb-5">
                <h2 class="section-title">Academic Programs</h2>
                <div class="row">
                    <div class="col-md-6 mb-4 program-card-container-left">
                        <div class="program-card">
                            <h3>BS in Information Technology</h3>
                            <p>A four-year program focusing on practical IT solutions, software development, and network administration.</p>
                            <ul class="program-features">
                                <li><i class="fas fa-check"></i> Web Development</li>
                                <li><i class="fas fa-check"></i> Database Management</li>
                                <li><i class="fas fa-check"></i> Network Administration</li>
                                <li><i class="fas fa-check"></i> Mobile App Development</li>
                            </ul>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bsitModal">
                                Learn More
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 program-card-container-right">
                        <div class="program-card">
                            <h3>BS in Computer Science</h3>
                            <p>A comprehensive program covering theoretical foundations and practical applications of computing.</p>
                            <ul class="program-features">
                                <li><i class="fas fa-check"></i> Algorithm Design</li>
                                <li><i class="fas fa-check"></i> Software Engineering</li>
                                <li><i class="fas fa-check"></i> Artificial Intelligence</li>
                                <li><i class="fas fa-check"></i> Data Science</li>
                            </ul>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bscsModal">
                                Learn More
                            </button>
                        </div>
                    </div>
                    
                </div>
            </section>

            <!-- Facilities Section -->
            <section class="facilities-section mb-5">
                <h2 class="section-title">Our Facilities</h2>
                <div class="row">
                    <div class="col-lg-6 mb-4 facility-card-container facility-card-container-left">
                        <div class="facility-card">
                            <img src="{{ asset('assets/img/OpenImages/facility.jpg') }}" alt="Computer Laboratory" class="img-fluid">
                            <div class="facility-content-container">
                                <div class="facility-content">
                                    <h3>Computer Laboratories</h3>
                                    <p class="m-0">State-of-the-art computer labs equipped with the latest hardware and software.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4 facility-card-container facility-card-container-right">
                        <div class="facility-card">
                            <img src="{{ asset('assets/img/OpenImages/network.jpg') }}" alt="Networking Laboratory" class="img-fluid">
                            <div class="facility-content-container">
                                <div class="facility-content">
                                    <h3>Networking Laboratory</h3>
                                    <p class="m-0">Specialized lab for network setup, configuration, and security training.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Faculty Section -->
            <section class="faculty-section">
                <h2 class="section-title">Our Faculty</h2>
                <p class="section-description">Learn from experienced professionals and academics in the field of computing.</p>
                
                <!-- Dean Section -->
                <div class="dean-section">
                    <h3 class="mb-4">Dean</h3>
                    <div class="dean-card">
                        <div class="dean-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof1.jp') }}" alt="Dr. Tan">
                            <div class="dean-overlay">
                                <h4 class="dean-name">Dr.Tan</h4>
                                <p class="dean-title">Dean, College of Computer Studies</p>
                            </div>
                        </div>
                        <div class="dean-info">
                            <h4 class="dean-name">Dr. Tan</h4>
                            <p class="dean-title">Dean, College of Computer Studies</p>
                            <p class="dean-expertise">Expertise: Artificial Intelligence, Machine Learning, Data Science</p>
                            <div class="dean-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Faculty Members -->
                <h3 class="mb-4 text-center">Faculty Members</h3>
                <div class="faculty-grid">
                    <!-- Faculty Card 2 -->
                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof2.jpg') }}" alt="Prof. John Cruz">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. John Cruz</h4>
                                <p class="faculty-title">Associate Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. John Cruz</h4>
                            <p class="faculty-title">Associate Professor</p>
                            <p class="faculty-expertise">Expertise: Software Engineering, Web Development, Cloud Computing</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty Card 3 -->
                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof3.jpg') }}" alt="Dr. Sarah Lim">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Dr. Sarah Lim</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Dr. Sarah Lim</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Cybersecurity, Network Administration, Ethical Hacking</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty Card 4 -->
                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div> <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div><div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="faculty-card">
                        <div class="faculty-image">
                            <img src="{{ asset('assets/img/OpenImages/faculty/prof4.jpg') }}" alt="Prof. Michael Tan">
                            <div class="faculty-overlay">
                                <h4 class="faculty-name">Prof. Michael Tan</h4>
                                <p class="faculty-title">Assistant Professor</p>
                            </div>
                        </div>
                        <div class="faculty-info">
                            <h4 class="faculty-name">Prof. Michael Tan</h4>
                            <p class="faculty-title">Assistant Professor</p>
                            <p class="faculty-expertise">Expertise: Database Systems, Big Data Analytics, Information Systems</p>
                            <div class="faculty-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-google-scholar"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
               

             

                </div>
            </section>
        </div>
    </main>

    <!-- Modals -->
    <!-- BSIT Modal -->
    <div class="modal fade" id="bsitModal" tabindex="-1" aria-labelledby="bsitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bsitModalLabel">Bachelor of Science in Information Technology (BSIT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The BSIT program is designed to equip students with the necessary skills to excel in the dynamic field of Information Technology. It focuses on the practical application of technology to solve real-world problems.</p>
                    <h6>Curriculum Highlights:</h6>
                    <ul>
                        <li>Web and Mobile Application Development</li>
                        <li>Database Design and Management</li>
                        <li>Network Administration and Security</li>
                        <li>Systems Analysis and Design</li>
                        <li>Cloud Computing Fundamentals</li>
                        <li>IT Project Management</li>
                    </ul>
                    <h6>Career Opportunities:</h6>
                    <p>Graduates can pursue careers as Software Developers, Web Developers, Network Administrators, Database Administrators, Systems Analysts, IT Support Specialists, and more.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BSCS Modal -->
    <div class="modal fade" id="bscsModal" tabindex="-1" aria-labelledby="bscsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bscsModalLabel">Bachelor of Science in Computer Science (BSCS)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The BSCS program provides a deep understanding of the theoretical foundations of computing, alongside practical programming skills. It prepares students for advanced studies and research in computer science.</p>
                    <h6>Curriculum Highlights:</h6>
                    <ul>
                        <li>Advanced Algorithm Design and Analysis</li>
                        <li>Software Engineering Principles</li>
                        <li>Operating Systems Concepts</li>
                        <li>Artificial Intelligence and Machine Learning</li>
                        <li>Computer Graphics and Visualization</li>
                        <li>Theory of Computation</li>
                    </ul>
                    <h6>Career Opportunities:</h6>
                    <p>Graduates often work as Software Engineers, AI Specialists, Data Scientists, Researchers, Game Developers, Systems Architects, or pursue advanced academic degrees.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
</x-open-layout>