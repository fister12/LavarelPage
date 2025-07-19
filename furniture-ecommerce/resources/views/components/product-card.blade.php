<div class="card h-100 position-relative">
    @if($product->is_on_sale)
        <div class="discount-badge">
            {{ $product->discount_percentage }}% OFF
        </div>
    @endif
    
    <div class="position-relative">
        <img src="{{ $product->main_image }}" 
             class="card-img-top product-image" 
             alt="{{ $product->name }}"
             loading="lazy">
        
        <!-- Wishlist Button -->
        <button type="button" 
                class="btn wishlist-btn" 
                data-product-id="{{ $product->id }}"
                onclick="toggleWishlist({{ $product->id }})"
                title="Add to Wishlist">
            <i class="far fa-heart"></i>
        </button>
        
        <!-- Quick Add to Cart Button -->
        <button type="button" 
                class="btn cart-btn" 
                onclick="addToCart({{ $product->id }})"
                title="Add to Cart">
            <i class="fas fa-shopping-cart"></i>
        </button>
    </div>
    
    <div class="card-body d-flex flex-column">
        <div class="mb-2">
            <small class="text-muted">{{ $product->category->name }}</small>
            @if($product->brand)
                <small class="text-muted"> • {{ $product->brand->name }}</small>
            @endif
        </div>
        
        <h6 class="card-title">
            <a href="{{ route('products.show', $product->slug) }}" 
               class="text-decoration-none text-dark">
                {{ $product->name }}
            </a>
        </h6>
        
        <p class="card-text text-muted small">{{ Str::limit($product->short_description, 80) }}</p>
        
        <!-- Rating -->
        @if($product->total_reviews > 0)
        <div class="mb-2">
            <div class="rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $product->average_rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <small class="text-muted">({{ $product->total_reviews }} reviews)</small>
        </div>
        @endif
        
        <!-- Price -->
        <div class="mt-auto">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    @if($product->is_on_sale)
                        <span class="price-sale h6 mb-0">₹{{ number_format($product->sale_price, 0) }}</span>
                        <span class="price-original ms-2">₹{{ number_format($product->price, 0) }}</span>
                    @else
                        <span class="h6 mb-0">₹{{ number_format($product->price, 0) }}</span>
                    @endif
                </div>
                
                <!-- Stock Status -->
                @if($product->stock_status === 'out_of_stock')
                    <small class="text-danger fw-bold">Out of Stock</small>
                @elseif($product->stock_quantity <= 5)
                    <small class="text-warning">Only {{ $product->stock_quantity }} left</small>
                @endif
            </div>
            
            <div class="d-grid mt-2">
                @if($product->stock_status === 'in_stock')
                    <button type="button" 
                            class="btn btn-primary btn-sm" 
                            onclick="addToCart({{ $product->id }})">
                        <i class="fas fa-cart-plus me-1"></i>Add to Cart
                    </button>
                @else
                    <button type="button" class="btn btn-secondary btn-sm" disabled>
                        Out of Stock
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
