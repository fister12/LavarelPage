<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            [
                'name' => 'Nilkamal',
                'slug' => 'nilkamal',
                'description' => 'India\'s largest furniture brand known for quality and innovation',
                'status' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'IKEA',
                'slug' => 'ikea',
                'description' => 'Swedish furniture retailer known for modern, functional design',
                'status' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Godrej Interio',
                'slug' => 'godrej-interio',
                'description' => 'Premium furniture and interior solutions',
                'status' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Urban Ladder',
                'slug' => 'urban-ladder',
                'description' => 'Contemporary furniture for modern homes',
                'status' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Pepperfry',
                'slug' => 'pepperfry',
                'description' => 'Stylish furniture and home decor solutions',
                'status' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Durian',
                'slug' => 'durian',
                'description' => 'Premium furniture with contemporary designs',
                'status' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Home Centre',
                'slug' => 'home-centre',
                'description' => 'Affordable furniture and home accessories',
                'status' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Woodsworth',
                'slug' => 'woodsworth',
                'description' => 'Solid wood furniture with traditional craftsmanship',
                'status' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'Crystal Furnitech',
                'slug' => 'crystal-furnitech',
                'description' => 'Modern furniture solutions for every space',
                'status' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'Spacewood',
                'slug' => 'spacewood',
                'description' => 'Innovative furniture designs for contemporary living',
                'status' => true,
                'sort_order' => 10
            ]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
