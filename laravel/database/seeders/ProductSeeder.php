<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'name' => 'Matcha Mochi',
            'description' => 'Delicious matcha-flavored mochi with a smooth, chewy texture. Made with premium green tea powder for an authentic taste.',
            'price' => 200.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Berry Mochi',
            'description' => 'Sweet strawberry mochi with a delightful fruity flavor. Soft and chewy with real strawberry filling.',
            'price' => 200.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Vanilla Mochi',
            'description' => 'Classic vanilla mochi with a creamy, sweet center. A timeless favorite for all mochi lovers.',
            'price' => 200.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Bean Mochi',
            'description' => 'Traditional red bean mochi with authentic sweet bean paste. A classic Japanese treat.',
            'price' => 200.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Chocolate Mochi',
            'description' => 'Rich and decadent chocolate mochi with a smooth chocolate filling. Perfect for chocolate lovers.',
            'price' => 220.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Red Bean Mochi',
            'description' => 'Traditional Japanese red bean paste mochi. Sweet and savory with authentic anko filling.',
            'price' => 200.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Taro Mochi',
            'description' => 'Purple taro-flavored mochi with a unique, earthy sweetness. A delightful Taiwanese-inspired treat.',
            'price' => 210.00,
            'image' => 'images/whatismochi.jpg',
        ]);

        \App\Models\Product::create([
            'name' => 'Sakura Mochi',
            'description' => 'Elegant cherry blossom mochi with delicate pink coloring and subtle floral notes. A seasonal Japanese delicacy.',
            'price' => 230.00,
            'image' => 'images/whatismochi.jpg',
        ]);
    }
}
