<x-open-layout>
    @section('title', 'Academics')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="{{ asset('/assets/css/OpenCSS/colleges.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('/assets/css/OpenCSS/colleges.css') }}">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/sr-colleges.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('/assets/js/OpenJS/dropdown.js') }}"></script>
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
                        <a href="index.html"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-two active" aria-current="page">Academics</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="choose-path">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 choose-path-img-container">
                    <img src="{{ asset('/assets/img/OpenImages/FLAG.jpg') }}" alt="Students with flags" class="img-fluid rounded">
                </div>
                <div class="col-lg-7 choose-path-text-container">
                    <h2 class="text-success pb-2">CHOOSE YOUR PATH, SHAPE YOUR FUTURE</h2>
                    <p class="mb-4">Pamantasan ng Lungsod ng Pasig offers diverse and industry-relevant programs across its colleges, equipping students with the knowledge, skills, and experience to excel in their chosen fields.</p>
                    <p>Committed to academic excellence and community development, PLP provides quality education that empowers Pasigueños to lead, innovate, and succeed</p>
                   
                </div>
            </div>
        </div>
    </section>

    <section class="colleges-content pt-5 pb-5">
        <div class="container">
            <div class="row"> <!-- College of Computer Studies -->
                <div class="col-md-4 mb-4 cc-left">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Computer Studies" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Computer Studies (CCS)</h3>
                            <p>The College of Computer Studies at Pamantasan ng Lungsod ng Pasig equips students with cutting-edge skills in programming, cybersecurity, and IT innovation. With a strong foundation in technology and hands-on learning, we prepare future-ready professionals for the fast-evolving digital world.</p>
                            <a href="ccs.html" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>

                <!-- College of Business Administration -->
                <div class="col-md-4 mb-4 cc-left">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Business Administration" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Business Administration (CBA)</h3>
                            <p>The College of Business Administration develops future business leaders with comprehensive knowledge in management, finance, and entrepreneurship. Our program prepares students for the dynamic business landscape.</p>
                            <a href="#" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>

                <!-- College of Education -->
                <div class="col-md-4 mb-4 cc-left">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Education" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Education (COE)</h3>
                            <p>The College of Education shapes future educators through comprehensive training in teaching methodologies, curriculum development, and educational technology. We prepare passionate teachers who inspire learning.</p>
                            <a href="#" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 cc-right">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Engineering" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Engineering (COE)</h3>
                            <p>The College of Computer Studies at Pamantasan ng Lungsod ng Pasig equips students with cutting-edge skills in programming, cybersecurity, and IT innovation. With a strong foundation in technology and hands-on learning, we prepare future-ready professionals for the fast-evolving digital world.</p>
                            <a href="ccs.html" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 cc-right">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Arts and Science" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Arts and Science (CAS)</h3>
                            <p>The College of Business Administration develops future business leaders with comprehensive knowledge in management, finance, and entrepreneurship. Our program prepares students for the dynamic business landscape.</p>
                            <a href="#" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4 cc-right">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of International Hospitality Management" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of International Hospitality Management (CIHM)</h3>
                            <p>The College of Education shapes future educators through comprehensive training in teaching methodologies, curriculum development, and educational technology. We prepare passionate teachers who inspire learning.</p>
                            <a href="#" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4 cc-left">
                    <div class="college-card">
                        <img src="{{ asset('/assets/img/OpenImages/COMSOC.jpg') }}" alt="College of Nursing" class="img-fluid w-100">
                        <div class="card-body p-3">
                            <h3 class="text-success">College of Nursing (CON)</h3>
                            <p>The College of Computer Studies at Pamantasan ng Lungsod ng Pasig equips students with cutting-edge skills in programming, cybersecurity, and IT innovation. With a strong foundation in technology and hands-on learning, we prepare future-ready professionals for the fast-evolving digital world.</p>
                            <a href="ccs.html" class="btn btn-success w-100">EXPLORE</a>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>

</x-open-layout>