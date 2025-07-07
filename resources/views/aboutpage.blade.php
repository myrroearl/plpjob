<x-open-layout>
    @section('title', 'About')
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/about.css') }}"">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script defer src="{{ asset('assets/js/OpenJS/about-imageslider.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/scroll-smooth.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/dropdown.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/timeline.js') }}"></script>
    <script defer src="{{ asset('assets/js/OpenJS/scrollreveal-about.js') }}"></script>

    <section class="image-header">
        <img src="{{ asset('assets/img/OpenImages/header.png') }}" alt="" srcset="">
    </section>

    <section class="mission-section">
        <div class="container-fluid mission-section-container">
            <div class="row">
                <div class="mission col-lg-6 mv-container">
                    <div class="mission-content container d-flex justify-content-center align-items-center flex-column">
                        <img src="{{ asset('assets/img/OpenImages/mission 1.png') }}" alt="" srcset="">
                        <h1>Mission</h1>
                        <p class="text-center">We, a community of service-oriented individuals, supported by the City Government of Pasig, are committed to lifelong learning and to produce graduates strong in their global outlook, cultural identity, and social responsibility through teaching strategies, methodologies, relevant research and dedicated public service.</p>
                    </div>
                </div>
                <div class="vision col-lg-6 mv-container">
                    <div class="vision-content container d-flex justify-content-center align-items-center flex-column">
                        <img src="{{ asset('assets/img/OpenImages/shared-vision 1.png') }}" alt="">
                        <h1>Vision</h1>
                        <p class="text-center">The Pamantasan ng Lungsod ng Pasig is a leading center for academic excellence among locally funded colleges and universities that produces responsible and productive individuals who are responsive to the changing demands of development locally and globally.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="core">
                    <div class="core-content container d-flex justify-content-center align-items-center flex-column">
                        <img src="{{ asset('assets/img/OpenImages/values 1.png') }}" alt="" srcset="">
                        <h1>Core Values</h1>
                        <p class="text-center">Academic Excellence, Cultural Identity, Peace Education, Sustainable Development, Social Equity and Responsibility, and Global Competitiveness.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

 
    <section class="timeline timeline-parallax">
        <div class="container timeline-container">
            <div class="timeline-header">
                <h1 class="m-0">Brief History of</h1>
                <h1 class="mb-4 fw-bolder">Pamantasan ng Lungsod ng Pasig</h1>
            </div>
            <ol>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>1999</time>
                        </div>
                        <div class="details">
                            <h3>Origin</h3>
                            <p>March 15, 1999</p>
                            <p>The Sangguniang Panlungsod ng Pasig passed Ordinance No. 11, Series of 1999, officially establishing Pamantasan ng Lungsod ng Pasig (PLP) and allocating funds for its operations.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2000</time>
                        </div>
                        <div class="details">
                            <h3>Expansion</h3>
                            <p>PLP became part of the Pasig City Development Plan, utilizing various modern facilities in the city, such as the City Library, Computer Center, Sports Complex, Convention Center, Museum, Livelihood & Youth Training Centers, Rainforest Park & Recreational Facilities, and Basic Education Schools.</p>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>Dr. Carolina P. Danao served as the Founding President from June 2000 to December 2005.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2006</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>Dr. Corazon M. Raymundo served on secondment from the University of the Philippines from January 2006 to March 2007.</p>
                            <p>Dr. Elsa R. Encabo served as Officer-in-Charge from April 2007 to July 2007.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2007</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>Dr. Nilo L. Rosas briefly served as president in August 2007 before being appointed as Commissioner of the Professional Regulation Commission by President Gloria Macapagal Arroyo.</p>
                            <p>Prof. Josefa A. Dimalanta served as Officer-in-Charge from August 2007 to January 2008.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2008</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>Hon. Ambassador Rosalinda Valenton-Tirona served as the third University President from January 2008 to 2010.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2011</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>In 2011, Dr. Hernando R. Gomez, then Vice President, was appointed as Acting University President.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2012</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>In January 2012, Amihan April M. Alcazar, Ph.D. Vice President for both Academic and Administrative Affairs, and was appointed the fourth University, with the Pasig City Council confirming her appointment as University President In October 2012.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item-inner">
                        <div class="time-wrapper">
                            <time>2013</time>
                        </div>
                        <div class="details">
                            <h3>University Leadership Timeline</h3>
                            <p>Amihan April M. Alcazar was sworn into office by the Chief Justice of the Supreme Court on February 28, 2013, in a formal ceremony held at the Supreme Court. She was officially invested as University President III by Hon. Robert C. Eusebio, Chairman of the Board and City Mayor of Pasig, on March 8, 2013, at Tanghalan Pasigueño in Pasig City, coinciding with the World Women's Day Celebration.</p>
                        </div>
                    </div>
                </li>
            </ol>
        </div>
    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</x-open-layout>