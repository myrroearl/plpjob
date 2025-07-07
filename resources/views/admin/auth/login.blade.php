<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: url(../assets/img/plpbg.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            height: 100vh;
            }

            .login-box {
            max-width: 520px;
            width: 100%;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }

            h1 {
            font-size: 2rem;
            }

            .form-group {
            position: relative;
            }

            .input-icon {
            padding: 0px 0px 0px 20px;
            }

            .input-icon1 {
            padding: 0px 0px 21px 20px;
            }

            .input-icon, .input-icon1,
            .input-icon-eye {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 20px;
            transition: all 0.3s ease;
            }

            .input-icon-eye {
            right: 20px;
            cursor: pointer;
            font-size: 22px;
            padding-bottom: 20px;
            }

            .input-icon-eye:hover {
            color: green;
            }

            input[type="password"],
            input[type="text"] {
            padding: 15px 50px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 25px;
            transition: all 0.3s ease-in-out;
            background: rgba(255, 255, 255, 0.9);
            }

            input[type="password"]:focus,
            input[type="text"]:focus {
            border-color: green;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 128, 0, 0.2);
            }

            .btn {
            background-color: green;
            color: white;
            padding: 14px 35px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 30px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 128, 0, 0.2);
            }

            .btn:hover {
            background-color: rgb(28, 194, 16);
            transform: scale(1.05);
            color: white;
            }

            a {
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease-in-out;
            }

            input:valid {
            border-color: #71c9ce;
            }

            @media (max-width: 576px) {
            .login-box {
                padding: 20px;
            }

            .input-icon,
            .input-icon-eye {
                font-size: 18px;
            }

            .btn-primary {
                padding: 10px 25px;
                font-size: 14px;
            }
        }

    </style>
</head>

<body>
    <section class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="login-box p-4 p-sm-5 shadow-lg">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/plp-logo.png') }}" alt="PLP Logo" class="img-fluid rounded-pill mb-4" style="max-width: 150px;">
                    <h1 class="fw-bold text-dark mb-3">Hello, Admin!</h1>
                    <p class="text-success fs-5">Pamantasan Lungsod ng Pasig</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.auth.login') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group mb-4 position-relative">
                        <input type="text" name="username" class="form-control rounded-pill px-5 py-3" placeholder="Enter your username" required />
                        <i class="fa fa-user position-absolute input-icon"></i>
                    </div>
    
                    <div class="form-group mb-4 position-relative">
                        <i class="fa-solid fa-lock position-absolute input-icon1"></i>
                        <input type="password" name="password" class="form-control rounded-pill px-5 py-3" placeholder="Enter your password" required />
                        <i id="togglePassword" class="fa fa-eye position-absolute input-icon-eye"></i>
                        
                    </div>
    
                    <div class="text-center mb-3">
                        <button type="submit" class="btn rounded-pill px-5 py-2 shadow">
                            <i class="fas fa-sign-in-alt me-2"></i>Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
    <script>
        // Password Toggle Functionality
        document.querySelector('#togglePassword').addEventListener('click', function () {
            const passwordField = document.querySelector('input[name="password"]');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
    
            // Toggle eye icon class
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);

            // Manual close button functionality
            $('.btn-close').on('click', function() {
                $(this).closest('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            });
        });

        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

