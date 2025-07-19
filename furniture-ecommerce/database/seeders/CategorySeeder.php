<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Living Room',
                'slug' => 'living-room',
                'description' => 'Comfortable and stylish furniture for your living space',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Sofas', 'slug' => 'sofas', 'description' => 'Comfortable sofas and seating'],
                    ['name' => 'Coffee Tables', 'slug' => 'coffee-tables', 'description' => 'Stylish coffee and center tables'],
                    ['name' => 'TV Units', 'slug' => 'tv-units', 'description' => 'Entertainment units and TV stands'],
                    ['name' => 'Recliners', 'slug' => 'recliners', 'description' => 'Comfortable reclining chairs'],
                    ['name' => 'Ottomans', 'slug' => 'ottomans', 'description' => 'Ottomans and footrests'],
                ]
            ],
            [
                'name' => 'Bedroom',
                'slug' => 'bedroom',
                'description' => 'Create your perfect bedroom sanctuary',
                'image' => 'https://images.unsplash.com/photo-1540518614846-7eded47337c6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Beds', 'slug' => 'beds', 'description' => 'Comfortable beds for all sizes'],
                    ['name' => 'Wardrobes', 'slug' => 'wardrobes', 'description' => 'Storage solutions for clothes'],
                    ['name' => 'Dressing Tables', 'slug' => 'dressing-tables', 'description' => 'Elegant dressing and vanity tables'],
                    ['name' => 'Nightstands', 'slug' => 'nightstands', 'description' => 'Bedside tables and storage'],
                    ['name' => 'Mattresses', 'slug' => 'mattresses', 'description' => 'Comfortable mattresses for better sleep'],
                ]
            ],
            [
                'name' => 'Dining Room',
                'slug' => 'dining-room',
                'description' => 'Elegant dining furniture for memorable meals',
                'image' => 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Dining Tables', 'slug' => 'dining-tables', 'description' => 'Tables for family dining'],
                    ['name' => 'Dining Chairs', 'slug' => 'dining-chairs', 'description' => 'Comfortable dining seating'],
                    ['name' => 'Dining Sets', 'slug' => 'dining-sets', 'description' => 'Complete dining room sets'],
                    ['name' => 'Bar Furniture', 'slug' => 'bar-furniture', 'description' => 'Bar stools and furniture'],
                    ['name' => 'Sideboards', 'slug' => 'sideboards', 'description' => 'Storage and serving furniture'],
                ]
            ],
            [
                'name' => 'Office',
                'slug' => 'office',
                'description' => 'Professional furniture for your workspace',
                'image' => 'https://images.unsplash.com/photo-1541558869434-2840d308329a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Office Chairs', 'slug' => 'office-chairs', 'description' => 'Ergonomic office seating'],
                    ['name' => 'Office Desks', 'slug' => 'office-desks', 'description' => 'Work desks and tables'],
                    ['name' => 'Storage', 'slug' => 'office-storage', 'description' => 'Filing cabinets and storage'],
                    ['name' => 'Bookcases', 'slug' => 'bookcases', 'description' => 'Shelving and bookcases'],
                ]
            ],
            [
                'name' => 'Kitchen',
                'slug' => 'kitchen',
                'description' => 'Functional and stylish kitchen furniture',
                'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 5,
                'children' => [
                    ['name' => 'Kitchen Islands', 'slug' => 'kitchen-islands', 'description' => 'Kitchen islands and carts'],
                    ['name' => 'Bar Stools', 'slug' => 'bar-stools', 'description' => 'Kitchen counter seating'],
                    ['name' => 'Kitchen Storage', 'slug' => 'kitchen-storage', 'description' => 'Pantry and storage solutions'],
                ]
            ],
            [
                'name' => 'Outdoor',
                'slug' => 'outdoor',
                'description' => 'Weather-resistant outdoor furniture',
                'image' => 'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'status' => true,
                'sort_order' => 6,
                'children' => [
                    ['name' => 'Patio Sets', 'slug' => 'patio-sets', 'description' => 'Complete outdoor dining sets'],
                    ['name' => 'Garden Chairs', 'slug' => 'garden-chairs', 'description' => 'Outdoor seating options'],
                    ['name' => 'Outdoor Tables', 'slug' => 'outdoor-tables', 'description' => 'Weather-resistant tables'],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['status'] = true;
                Category::create($childData);
            }
        }
    }
}
