@extends('layouts.app')

@section('title', 'All Products - Furniture Store')
@section('description', 'Browse our complete collection of premium furniture for every room and style.')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Filters</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                        <!-- Categories -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Categories</h6>
                            @foreach($categories as $category)
                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" 
                                           value="{{ $category->slug }}" id="category_{{ $category->id }}"
                                           {{ request('category') === $category->slug ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @if($category->children->count() > 0)
                                    <div class="ms-3">
                                        @foreach($category->children as $child)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" 
                                                   value="{{ $child->slug }}" id="category_{{ $child->id }}"
                                                   {{ request('category') === $child->slug ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category_{{ $child->id }}">
                                                {{ $child->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Price Range</h6>
                            <div class="row g-2">
                                <div class="col">
                                    <input type="number" name="min_price" class="form-control form-control-sm" 
                                           placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col">
                                    <input type="number" name="max_price" class="form-control form-control-sm" 
                                           placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Brands -->
                        @if($brands->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Brands</h6>
                            @foreach($brands as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="brand" 
                                       value="{{ $brand->slug }}" id="brand_{{ $brand->id }}"
                                       {{ request('brand') === $brand->slug ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Room Type -->
                        @if($roomTypes->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Room Type</h6>
                            @foreach($roomTypes as $roomType)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="room_type" 
                                       value="{{ $roomType }}" id="room_{{ $loop->index }}"
                                       {{ request('room_type') === $roomType ? 'checked' : '' }}>
                                <label class="form-check-label" for="room_{{ $loop->index }}">
                                    {{ ucfirst(str_replace('_', ' ', $roomType)) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Material -->
                        @if($materials->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Material</h6>
                            @foreach($materials as $material)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="material" 
                                       value="{{ $material }}" id="material_{{ $loop->index }}"
                                       {{ request('material') === $material ? 'checked' : '' }}>
                                <label class="form-check-label" for="material_{{ $loop->index }}">
                                    {{ $material }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Color -->
                        @if($colors->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Color</h6>
                            @foreach($colors as $color)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="color" 
                                       value="{{ $color }}" id="color_{{ $loop->index }}"
                                       {{ request('color') === $color ? 'checked' : '' }}>
                                <label class="form-check-label" for="color_{{ $loop->index }}">
                                    {{ $color }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear All</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Sort and View Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-muted">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} 
                    of {{ $products->total() }} products
                </p>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <label class="form-label me-2 mb-0">Sort by:</label>
                        <select class="form-select form-select-sm" style="width: auto;" onchange="updateSort(this.value)">
                            <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="price_low_high" {{ request('sort_by') === 'price_low_high' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="price_high_low" {{ request('sort_by') === 'price_high_low' ? 'selected' : '' }}>Price High to Low</option>
                            <option value="newest" {{ request('sort_by') === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>Best Rated</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    @include('components.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4>No Products Found</h4>
                <p class="text-muted">Try adjusting your filters or search criteria.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateSort(sortBy) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort_by', sortBy);
    window.location.href = url.toString();
}

// Auto-submit form when filters change
$(document).ready(function() {
    $('#filter-form input[type="radio"], #filter-form input[type="number"]').on('change input', function() {
        // Debounce for number inputs
        if ($(this).attr('type') === 'number') {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                $('#filter-form').submit();
            }, 1000);
        } else {
            $('#filter-form').submit();
        }
    });
});
</script>
@endpush
@endsection
