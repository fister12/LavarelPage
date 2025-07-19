<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Furniture Store - Premium Furniture for Every Home')</title>
    <meta name="description" content="@yield('description', 'Discover premium furniture for living room, bedroom, dining room, and office. Quality furniture with modern designs and competitive prices.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #CD853F;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .product-image {
            height: 250px;
            object-fit: cover;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 80px 0;
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0 20px;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wishlist-btn, .cart-btn {
            position: absolute;
            top: 10px;
            background: rgba(255,255,255,0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .wishlist-btn {
            right: 10px;
        }

        .cart-btn {
            right: 60px;
        }

        .wishlist-btn:hover, .cart-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .price-original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .price-sale {
            color: #dc3545;
            font-weight: 600;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .rating {
            color: #ffc107;
        }

        .category-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(139,69,19,0.8), rgba(210,105,30,0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover .category-overlay {
            opacity: 1;
        }

        .search-form {
            position: relative;
        }

        .search-input {
            border-radius: 25px;
            padding: 10px 50px 10px 20px;
            border: 2px solid #e9ecef;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="bg-dark text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small>
                        <i class="fas fa-phone me-2"></i>+91 1800-123-4567
                        <span class="ms-3">
                            <i class="fas fa-envelope me-2"></i>info@furniturestore.com
                        </span>
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <small>Free shipping on orders over ₹10,000</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-couch me-2"></i>FurnitureStore
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Shop by Room
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index', ['room_type' => 'living_room']) }}">Living Room</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['room_type' => 'bedroom']) }}">Bedroom</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['room_type' => 'dining_room']) }}">Dining Room</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['room_type' => 'office']) }}">Office</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['room_type' => 'kitchen']) }}">Kitchen</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index', ['featured' => 1]) }}">Featured</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index', ['sale' => 1]) }}">Sale</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="search-form me-3" action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" class="form-control search-input" placeholder="Search furniture..." value="{{ request('q') }}">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('wishlist.index') }}">
                                <i class="fas fa-heart"></i>
                                <span class="cart-badge" id="wishlist-count">0</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                    
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="text-primary mb-3">FurnitureStore</h5>
                    <p>Your one-stop destination for premium furniture. We bring style, comfort, and quality to every home.</p>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-light text-decoration-none">Products</a></li>
                        <li><a href="#" class="text-light text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Categories</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index', ['room_type' => 'living_room']) }}" class="text-light text-decoration-none">Living Room</a></li>
                        <li><a href="{{ route('products.index', ['room_type' => 'bedroom']) }}" class="text-light text-decoration-none">Bedroom</a></li>
                        <li><a href="{{ route('products.index', ['room_type' => 'dining_room']) }}" class="text-light text-decoration-none">Dining Room</a></li>
                        <li><a href="{{ route('products.index', ['room_type' => 'office']) }}" class="text-light text-decoration-none">Office</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Shipping Info</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Returns</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Size Guide</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="text-light"><i class="fas fa-map-marker-alt me-2"></i>123 Furniture St, City</li>
                        <li class="text-light"><i class="fas fa-phone me-2"></i>+91 1800-123-4567</li>
                        <li class="text-light"><i class="fas fa-envelope me-2"></i>info@furniturestore.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} FurnitureStore. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Update cart count on page load
        $(document).ready(function() {
            updateCartCount();
            updateWishlistCount();
        });

        function updateCartCount() {
            $.get('{{ route('cart.count') }}', function(data) {
                $('#cart-count').text(data.count);
            });
        }

        function updateWishlistCount() {
            @auth
            // Add wishlist count update logic here
            @endauth
        }

        // Add to cart functionality
        function addToCart(productId, quantity = 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ route('cart.add') }}', {
                product_id: productId,
                quantity: quantity
            }, function(response) {
                if (response.success) {
                    $('#cart-count').text(response.cart_count);
                    showToast('success', response.message);
                } else {
                    showToast('error', response.message);
                }
            }).fail(function() {
                showToast('error', 'An error occurred. Please try again.');
            });
        }

        // Add to wishlist functionality
        function toggleWishlist(productId) {
            @auth
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ route('wishlist.toggle') }}', {
                product_id: productId
            }, function(response) {
                if (response.success) {
                    showToast('success', response.message);
                    // Update wishlist icon
                    const heartIcon = $(`.wishlist-btn[data-product-id="${productId}"] i`);
                    if (response.in_wishlist) {
                        heartIcon.removeClass('far').addClass('fas text-danger');
                    } else {
                        heartIcon.removeClass('fas text-danger').addClass('far');
                    }
                } else {
                    showToast('error', response.message);
                }
            }).fail(function() {
                showToast('error', 'An error occurred. Please try again.');
            });
            @else
            window.location.href = '{{ route('login') }}';
            @endauth
        }

        // Toast notifications
        function showToast(type, message) {
            const toast = $(`
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `);

            if (!$('#toast-container').length) {
                $('body').append('<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>');
            }

            $('#toast-container').append(toast);
            const toastInstance = new bootstrap.Toast(toast[0]);
            toastInstance.show();

            toast.on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
