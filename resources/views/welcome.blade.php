<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Landing Page</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/shopping-cart.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1600x900/?shopping') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">E-Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <div>
                    @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to E-Shop</h1>
            <p>Your one-stop destination for amazing products</p>
            <a href="#" class="btn btn-light btn-lg">Shop Now</a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
