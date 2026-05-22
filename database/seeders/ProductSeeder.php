<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TASK ASSIGNMENT: MEMBER 1 (Billiones - Frontend Storefront Integration)
        //  SUB-TASK: Storefront Department & Catalog Classification Seed Blocks
        $electronics = Category::create([
            'name' => 'Electronics', 
            'slug' => 'electronics',
            'image_url' => 'https://res.cloudinary.com/iwh/image/upload/q_auto,g_center/h_768/assets/1/26/Jensen7623M_Main_Image.jpg'
        ]);

        $computers = Category::create([
            'name' => 'Computers', 
            'slug' => 'computers',
            'image_url' => 'https://res.cloudinary.com/iwh/image/upload/q_auto,g_center/h_768/assets/1/26/Jensen7623M_Main_Image.jpg'
        ]);

        $clothes = Category::create([
            'name' => 'Clothes', 
            'slug' => 'clothes',
            'image_url' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=300&q=80'
        ]);

        $arts = Category::create([
            'name' => 'Arts', 
            'slug' => 'arts-crafts',
            'image_url' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=300&q=80'
        ]);

         $crafts = Category::create([
            'name' => 'crafts', 
            'slug' => 'crafts',
            'image_url' => 'https://diycandy.com/wp-content/uploads/2022/09/Easy-flower-crafts-for-kids-featured.jpg'
        ]);

        $toys = Category::create([
            'name' => 'Toys', 
            'slug' => 'toys',
            'image_url' => 'https://images.unsplash.com/photo-1566577134770-3d85bb3a9cc4?auto=format&fit=crop&w=300&q=80'
        ]);
        
        // 👤 TASK ASSIGNMENT: MEMBER 4 (Francis - Admin Inventory API Management)
        // SUB-TASK: Inventory Asset Generation & Structural Relationship Ingestion
        // --- Electronics ---
        $prod1 = Product::create([
            'category_id' => $electronics->id,
            'name' => 'Wireless Noise-Canceling Headphones',
            'brand' => 'TriBee Sound',
            'description' => 'Premium over-ear wireless headphones with hybrid active noise cancellation.',
            'price' => 1499.00,
            'slug' => 'wireless-noise-canceling-headphones',
            'image' => 'https://www.yamanelectronics.com/wp-content/uploads/2022/08/top-soldering-kit-for-electronics.jpg'
        ]);
        $prod1->inventory()->create(['stock' => 15]);

         $prod1 = Product::create([
            'category_id' => $electronics->id,
            'name' => 'Computer Repair Tool Kit',
            'brand' => 'TriBee Sound',
            'description' => 'Professional tool kit for computer repair and maintenance.',
            'price' => 1499.00,
            'slug' => 'computer-repair-tool-kit',
            'image' => 'https://m.media-amazon.com/images/I/81vCPnQtyCL.jpg'
        ]);
        $prod1->inventory()->create(['stock' => 18]);

         $prod1 = Product::create([
            'category_id' => $electronics->id,
            'name' => 'Engineering Computer Repair Tool Kit,6 Molded case',
            'brand' => 'TriBee Sound',
            'description' => 'Standard engineering tool kit for computer repair and maintenance.',
            'price' => 1499.00,
            'slug' => 'engineering-computer-repair-tool-kit',
            'image' => 'https://cdn.shopify.com/s/files/1/1026/4509/products/SPC47D_grande.jpg?v=1661289677'
        ]);
        $prod1->inventory()->create(['stock' => 25]);


        // --- Computers ---
        $prod2 = Product::create([
            'category_id' => $computers->id,
            'name' => 'Mechanical Gaming Keyboard',
            'brand' => 'TriBee Tech',
            'description' => 'RGB backlit mechanical keyboard with tactile blue switches and detachable cable.',
            'price' => 2499.00,
            'slug' => 'mechanical-gaming-keyboard',
            'image' => 'https://c1.neweggimages.com/productimage/nb1280/BRCGS2407310JXHLS00.jpg',
        ]);
        $prod2->inventory()->create(['stock' => 8]);

        // --- Clothes ---
        $prod3 = Product::create([
            'category_id' => $clothes->id,
            'name' => 'Oversized Minimalist Graphic Tee',
            'brand' => 'TriBee Threads',
            'description' => '100% heavy premium cotton streetwear shirt with breathable comfort fit.',
            'price' => 450.00,
            'slug' => 'oversized-minimalist-graphic-tee',
            'image' => 'https://assets.myntassets.com/h_200,w_200,c_fill,g_auto/h_1440,q_100,w_1080/v1/assets/images/2024/OCTOBER/4/JKXYSTo3_6a9cb6348f9a4a3e81c68b8466231137.jpg',
        ]);
        $prod3->inventory()->create(['stock' => 30]);

        // --- Arts & Crafts ---
        $prod4 = Product::create([
            'category_id' => $arts->id,
            'name' => 'Dual-Tip Acrylic Paint Marker Set',
            'brand' => 'ArtisanHub',
            'description' => '24-pack vibrant water-based permanent markers perfect for canvas, wood, and ceramic crafts.',
            'price' => 680.00,
            'slug' => 'dual-tip-acrylic-paint-marker-set',
            'image' => 'https://tse2.mm.bing.net/th/id/OIP.LtaMOiUXU7hiHjzKqipaxAHaHa?w=1000&h=1000&rs=1&pid=ImgDetMain&o=7&rm=3'
        ]);
        $prod4->inventory()->create(['stock' => 12]);

         $prod4 = Product::create([
            'category_id' => $crafts->id,
            'name' => 'Paint Marker Set',
            'brand' => 'ArtisanHub',
            'description' => 'A set of paint markers for various crafting needs.',
            'price' => 980.00,
            'slug' => 'paint-marker-set',
            'image' => 'https://hearthandvine.com/wp-content/uploads/2023/06/summer-adult-crafts-sq.jpg'
        ]);
        $prod4->inventory()->create(['stock' => 12]);

        // --- Toys ---
        $prod5 = Product::create([
            'category_id' => $toys->id,
            'name' => 'Colorful Building Block Set',
            'brand' => 'FlexStride Gaming',
            'description' => 'A set of colorful building blocks for creative play and development.',
            'price' => 1850.00,
            'slug' => 'colorful-building-block-set',
            'image' => 'https://static.vecteezy.com/system/resources/previews/028/535/140/non_2x/many-colorful-toys-collection-on-the-desk-generative-ai-photo.jpg'
        ]);

        $prod5->inventory()->create(['stock' => 10]);


        $prod5 = Product::create([
            'category_id' => $toys->id,
            'name' => 'Cartoon Character Plush Toy',
            'brand' => 'FlexStride Gaming',
            'description' => 'Soft and cuddly plush toy featuring a beloved cartoon character.',
            'price' => 1850.00,
            'slug' => 'cartoon-character-plush-toy',
            'image' => 'https://i5.walmartimages.com/seo/MaoGoLan-14-7-Packs-Teddy-Bear-7-Colors-Cute-Bulk-Stuffed-Animals_4797a20b-14b2-4d67-aab8-d103b715887d.afb4d8a146b81f003ec81aed12ad052e.jpeg'
        ]);

        $prod5->inventory()->create(['stock' => 60]);
    }
}