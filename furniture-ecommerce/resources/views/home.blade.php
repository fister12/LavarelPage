@extends('layouts.app')

@section('title', 'Premium Furniture Store - Quality Furniture for Every Home')
@section('description', 'Shop the finest collection of furniture for living room, bedroom, dining room, and office. Discover premium quality furniture with modern designs at competitive prices.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Transform Your Home with Premium Furniture</h1>
                <p class="lead mb-4">Discover our exclusive collection of modern and classic furniture designed to bring comfort and style to every room in your home.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">Shop Now</a>
                    <a href="{{ route('products.index', ['featured' => 1]) }}" class="btn btn-outline-light btn-lg">Featured Products</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Premium Furniture" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Main Categories -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Shop by Room</h2>
            <p class="text-muted">Find the perfect furniture for every space in your home</p>
        </div>
        <div class="row g-4">
            @foreach($mainCategories as $category)
            <div class="col-lg-4 col-md-6">
                <div class="card category-card h-100">
                    <img src="{{ $category->image ?: 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                         class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $category->name }}">
                    <div class="category-overlay">
                        <div class="text-center">
                            <h4>{{ $category->name }}</h4>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="btn btn-light mt-2">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Products</h2>
            <p class="text-muted">Handpicked furniture pieces that define elegance and comfort</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index', ['featured' => 1]) }}" class="btn btn-primary btn-lg">View All Featured</a>
        </div>
    </div>
</section>
@endif

<!-- New Arrivals -->
@if($newArrivals->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">New Arrivals</h2>
            <p class="text-muted">Latest additions to our furniture collection</p>
        </div>
        <div class="row g-4">
            @foreach($newArrivals as $product)
            <div class="col-lg-3 col-md-6">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index', ['sort_by' => 'newest']) }}" class="btn btn-outline-primary btn-lg">View All New</a>
        </div>
    </div>
</section>
@endif

<!-- Best Sellers -->
@if($bestSellers->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Best Sellers</h2>
            <p class="text-muted">Most popular furniture pieces loved by our customers</p>
        </div>
        <div class="row g-4">
            @foreach($bestSellers as $product)
            <div class="col-lg-3 col-md-6">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">View All Products</a>
        </div>
    </div>
</section>
@endif

<!-- Sale Products -->
@if($saleProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-danger">Special Offers</h2>
            <p class="text-muted">Limited time deals on premium furniture</p>
        </div>
        <div class="row g-4">
            @foreach($saleProducts as $product)
            <div class="col-lg-3 col-md-6">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('products.index', ['sale' => 1]) }}" class="btn btn-danger btn-lg">View All Offers</a>
        </div>
    </div>
</section>
@endif

<!-- Popular Brands -->
@if($popularBrands->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Popular Brands</h2>
            <p class="text-muted">Trusted furniture brands we partner with</p>
        </div>
        <div class="row g-4 align-items-center">
            @foreach($popularBrands as $brand)
            <div class="col-lg-3 col-md-4 col-6 text-center">
                <div class="p-3">
                    @if($brand->logo)
                        <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="img-fluid" style="max-height: 80px;">
                    @else
                        <h5 class="text-muted">{{ $brand->name }}</h5>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h5>Free Shipping</h5>
                    <p class="text-muted">Free delivery on orders over ₹10,000</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Quality Guarantee</h5>
                    <p class="text-muted">Premium quality furniture with warranty</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                    <h5>Easy Returns</h5>
                    <p class="text-muted">30-day hassle-free return policy</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted">Round the clock customer support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-3">Stay Updated with Latest Offers</h3>
                <p class="mb-0">Subscribe to our newsletter and get exclusive deals and new product updates.</p>
            </div>
            <div class="col-lg-6">
                <form class="row g-2">
                    <div class="col">
                        <input type="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-light">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
