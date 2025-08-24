<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Créer quelques catégories
        $categories = [
            'Cafés Arabica',
            'Cafés Robusta',
            'Cafés Décaféinés'
        ];

        foreach ($categories as $catName) {
            $category = Category::create(['name' => $catName]);

            // Créer quelques produits par catégorie
            for ($i = 1; $i <= 3; $i++) {
                Product::create([
                    'name' => "$catName - Produit $i",
                    'description' => "Description du produit $i dans la catégorie $catName",
                    'origin' => 'Brésil',
                    'price' => random_int(5, 15) + 0.99,
                    'stock' => random_int(10, 100),
                    'category_id' => $category->id
                ]);
            }
        }
    }
}
