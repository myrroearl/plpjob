<x-open-layout>
    @section('title', 'Contact')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/OpenCSS/contact.css') }}">
    <script defer src="{{ asset('assets/js/OpenJS/sr-contact.js') }}"></script>

    <section class="contact-header">
        <img src="{{ asset('assets/css/OpenImages/PM-pasig1.png') }}" alt="" srcset="" class="img-fluid w-100">
    </section>

    <section class="contact-content py-5">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2 class="contact-heading">Send Us An Email</h2>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contactNumber">Contact number</label>
                            <input type="tel" class="form-control" id="contactNumber" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your message (optional)</label>
                            <textarea class="form-control" id="message" rows="6"></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>

                <!-- Map Section -->
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.6482934133946!2d121.07217507476575!3d14.562094085919728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c87941df8e2b%3A0xc7cd5073d3d73742!2sPamantasan%20ng%20Lungsod%20ng%20Pasig!5e0!3m2!1sen!2sph!4v1744901844325!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
</x-open-layout>