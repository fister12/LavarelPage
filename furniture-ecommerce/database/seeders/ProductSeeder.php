<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::whereNotNull('parent_id')->get();
        $brands = Brand::all();

        $products = [
            // Living Room - Sofas
            [
                'name' => 'Nilkamal Sierra 3 Seater Recliner Sofa',
                'slug' => 'nilkamal-sierra-3-seater-recliner-sofa',
                'description' => 'Experience ultimate comfort with the Sierra 3 Seater Recliner Sofa. Features high-quality upholstery, sturdy frame construction, and smooth reclining mechanism. Perfect for family movie nights and relaxation.',
                'short_description' => 'Comfortable 3-seater recliner sofa with premium upholstery',
                'sku' => 'NLK-SIERRA-3S-001',
                'price' => 85000,
                'sale_price' => 67900,
                'cost_price' => 45000,
                'stock_quantity' => 15,
                'weight' => 85.5,
                'dimensions' => ['length' => 220, 'width' => 95, 'height' => 100],
                'category' => 'sofas',
                'brand' => 'nilkamal',
                'featured' => true,
                'material' => 'Fabric',
                'color' => 'Brown',
                'style' => 'Modern',
                'room_type' => 'living_room',
                'gallery' => [
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],
            [
                'name' => 'IKEA KIVIK 3-Seat Sofa',
                'slug' => 'ikea-kivik-3-seat-sofa',
                'description' => 'The KIVIK sofa combines comfort and style with its deep seats and soft back cushions. The durable frame and washable covers make it perfect for everyday use.',
                'short_description' => 'Scandinavian-style 3-seat sofa with washable covers',
                'sku' => 'IKEA-KIVIK-3S-002',
                'price' => 45000,
                'sale_price' => null,
                'cost_price' => 28000,
                'stock_quantity' => 8,
                'weight' => 65.0,
                'dimensions' => ['length' => 228, 'width' => 95, 'height' => 83],
                'category' => 'sofas',
                'brand' => 'ikea',
                'featured' => false,
                'material' => 'Fabric',
                'color' => 'Grey',
                'style' => 'Scandinavian',
                'room_type' => 'living_room',
                'gallery' => [
                    'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Living Room - Coffee Tables
            [
                'name' => 'Urban Ladder Epsilon Coffee Table',
                'slug' => 'urban-ladder-epsilon-coffee-table',
                'description' => 'Contemporary coffee table with clean lines and practical storage. Made from engineered wood with a beautiful walnut finish. Features a spacious tabletop and lower shelf for books and magazines.',
                'short_description' => 'Modern coffee table with storage shelf',
                'sku' => 'UL-EPSILON-CT-003',
                'price' => 18500,
                'sale_price' => 14500,
                'cost_price' => 9000,
                'stock_quantity' => 25,
                'weight' => 22.0,
                'dimensions' => ['length' => 120, 'width' => 60, 'height' => 45],
                'category' => 'coffee-tables',
                'brand' => 'urban-ladder',
                'featured' => true,
                'material' => 'Engineered Wood',
                'color' => 'Walnut',
                'style' => 'Contemporary',
                'room_type' => 'living_room',
                'gallery' => [
                    'https://images.unsplash.com/photo-1549497538-303791108f95?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Bedroom - Beds
            [
                'name' => 'Godrej Interio Slumber King Size Bed',
                'slug' => 'godrej-interio-slumber-king-size-bed',
                'description' => 'Elegant king-size bed with upholstered headboard and solid wood frame. Features premium fabric upholstery and sturdy construction for lasting comfort.',
                'short_description' => 'King-size bed with upholstered headboard',
                'sku' => 'GI-SLUMBER-KS-004',
                'price' => 65000,
                'sale_price' => 52000,
                'cost_price' => 35000,
                'stock_quantity' => 12,
                'weight' => 75.0,
                'dimensions' => ['length' => 215, 'width' => 185, 'height' => 120],
                'category' => 'beds',
                'brand' => 'godrej-interio',
                'featured' => true,
                'material' => 'Solid Wood',
                'color' => 'Dark Brown',
                'style' => 'Contemporary',
                'room_type' => 'bedroom',
                'gallery' => [
                    'https://images.unsplash.com/photo-1540518614846-7eded47337c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Bedroom - Wardrobes
            [
                'name' => 'Nilkamal Willy 3 Door Wardrobe',
                'slug' => 'nilkamal-willy-3-door-wardrobe',
                'description' => 'Spacious 3-door wardrobe with multiple compartments and hanging space. Features durable engineered wood construction with a sophisticated finish.',
                'short_description' => '3-door wardrobe with ample storage space',
                'sku' => 'NLK-WILLY-3D-005',
                'price' => 28500,
                'sale_price' => 22500,
                'cost_price' => 15000,
                'stock_quantity' => 18,
                'weight' => 95.0,
                'dimensions' => ['length' => 135, 'width' => 55, 'height' => 200],
                'category' => 'wardrobes',
                'brand' => 'nilkamal',
                'featured' => true,
                'material' => 'Engineered Wood',
                'color' => 'Wenge',
                'style' => 'Modern',
                'room_type' => 'bedroom',
                'gallery' => [
                    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Dining Room - Dining Sets
            [
                'name' => 'Durian Valencia 6 Seater Dining Set',
                'slug' => 'durian-valencia-6-seater-dining-set',
                'description' => 'Complete dining set with rectangular table and 6 upholstered chairs. Features solid wood construction with elegant design perfect for family dining.',
                'short_description' => '6-seater dining set with upholstered chairs',
                'sku' => 'DUR-VALENCIA-6S-006',
                'price' => 75000,
                'sale_price' => 58500,
                'cost_price' => 40000,
                'stock_quantity' => 6,
                'weight' => 120.0,
                'dimensions' => ['length' => 180, 'width' => 90, 'height' => 75],
                'category' => 'dining-sets',
                'brand' => 'durian',
                'featured' => true,
                'material' => 'Solid Wood',
                'color' => 'Natural',
                'style' => 'Traditional',
                'room_type' => 'dining_room',
                'gallery' => [
                    'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Office - Office Chairs
            [
                'name' => 'Godrej Interio Virtue Executive Chair',
                'slug' => 'godrej-interio-virtue-executive-chair',
                'description' => 'Ergonomic executive chair with lumbar support and adjustable features. Premium leather upholstery and synchronized mechanism for maximum comfort during long work hours.',
                'short_description' => 'Ergonomic executive chair with lumbar support',
                'sku' => 'GI-VIRTUE-EX-007',
                'price' => 25000,
                'sale_price' => 19500,
                'cost_price' => 12000,
                'stock_quantity' => 30,
                'weight' => 18.5,
                'dimensions' => ['length' => 70, 'width' => 70, 'height' => 120],
                'category' => 'office-chairs',
                'brand' => 'godrej-interio',
                'featured' => false,
                'material' => 'Leather',
                'color' => 'Black',
                'style' => 'Executive',
                'room_type' => 'office',
                'gallery' => [
                    'https://images.unsplash.com/photo-1541558869434-2840d308329a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ],

            // Office - Office Desks
            [
                'name' => 'Spacewood Optima Study Table',
                'slug' => 'spacewood-optima-study-table',
                'description' => 'Functional study table with built-in storage and cable management. Perfect for home office or student workspace with modern design and durable construction.',
                'short_description' => 'Study table with built-in storage',
                'sku' => 'SW-OPTIMA-ST-008',
                'price' => 15500,
                'sale_price' => null,
                'cost_price' => 8500,
                'stock_quantity' => 22,
                'weight' => 35.0,
                'dimensions' => ['length' => 120, 'width' => 60, 'height' => 75],
                'category' => 'office-desks',
                'brand' => 'spacewood',
                'featured' => false,
                'material' => 'Engineered Wood',
                'color' => 'Oak',
                'style' => 'Modern',
                'room_type' => 'office',
                'gallery' => [
                    'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]
            ]
        ];

        foreach ($products as $productData) {
            // Find category and brand
            $category = $categories->where('slug', $productData['category'])->first();
            $brand = $brands->where('slug', $productData['brand'])->first();

            if ($category && $brand) {
                unset($productData['category'], $productData['brand']);
                
                Product::create([
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'status' => true,
                    'stock_status' => 'in_stock',
                    'manage_stock' => true,
                    ...$productData
                ]);
            }
        }
    }
}
