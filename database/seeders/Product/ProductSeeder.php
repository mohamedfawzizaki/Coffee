<?php

namespace Database\Seeders\Product;

use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Models\Product\Product\Productsize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerAr = \Faker\Factory::create('ar_SA');
        $fakerEn = \Faker\Factory::create('en_US');

        for ($i = 0; $i < 10; $i++) {
            $category = PCategory::create([
                'ar' => [
                    'title' => $fakerAr->words(3, true),
                ],
                'en' => [
                    'title' => $fakerEn->words(3, true),
                ],
            ]);

            for ($j = 0; $j < 15; $j++) {

                $product = Product::create([
                    'ar' => [
                        'title'   => $fakerAr->words(3, true),
                        'content' => $fakerAr->paragraph,
                    ],
                    'en' => [
                        'title'   => $fakerEn->words(3, true),
                        'content' => $fakerEn->paragraph,
                    ],
                    'price'       => $fakerEn->randomFloat(2, 1, 100),
                    'points'      => rand(10, 500),
                    'category_id' => $category->id,
                ]);

                $sizes = ['صغير', 'متوسط', 'كبير'];
                $enSizes = ['Small', 'Medium', 'Large'];

                if ($j % 2 == 0) {
                    foreach ($sizes as $index => $size) {
                        $price = $fakerEn->randomFloat(2, 1, 100);

                        if ($index == 0) {
                            $product->update(['price' => $price]);
                        }

                        Productsize::create([
                            'product_id' => $product->id,
                            'ar_title' => $size,
                            'en_title' => $enSizes[$index],
                            'price' => $price,
                        ]);
                    }
                }
            }
        }
    }
}