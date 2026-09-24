<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@paraisodosmantos.com'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );

        $products = [
            [
                'name' => 'Camisa Real Madrid Clássica',
                'team' => 'Real Madrid',
                'season' => '2009/10',
                'description' => 'Camisa branca clássica do Real Madrid, inspirada em uma era marcante do clube espanhol.',
                'price' => 229.90,
                'compare_price' => 279.90,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/8/84/Kit_body_realmadrid32010.png',
                'sizes' => ['P', 'M', 'G', 'GG'],
                'stock' => 18,
                'featured' => true,
                'active' => true,
            ],
            [
                'name' => 'Camisa FC Barcelona Retrô',
                'team' => 'Barcelona',
                'season' => '2005/06',
                'description' => 'Manto grená e azul inspirado na camisa histórica do Barcelona da temporada 2005/06.',
                'price' => 219.90,
                'compare_price' => 259.90,
                'image_url' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/5/59/Fcb-2005-2006-home-shirt.jpg/960px-Fcb-2005-2006-home-shirt.jpg',
                'sizes' => ['P', 'M', 'G', 'GG'],
                'stock' => 16,
                'featured' => true,
                'active' => true,
            ],
            [
                'name' => 'Camisa Manchester City Vintage',
                'team' => 'Manchester City',
                'season' => '2011/12',
                'description' => 'Camisa azul-celeste inspirada no uniforme clássico do Manchester City.',
                'price' => 209.90,
                'compare_price' => 249.90,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Kit_body_mcfc_home_11-12.png',
                'sizes' => ['P', 'M', 'G', 'GG'],
                'stock' => 14,
                'featured' => true,
                'active' => true,
            ],
            [
                'name' => 'Camisa Paris Saint-Germain Retrô',
                'team' => 'PSG',
                'season' => '2020/21',
                'description' => 'Manto azul-marinho do Paris Saint-Germain com faixa central em referência à identidade parisiense.',
                'price' => 219.90,
                'compare_price' => 259.90,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/b7/Kit_body_psg2021a.png',
                'sizes' => ['P', 'M', 'G', 'GG'],
                'stock' => 15,
                'featured' => false,
                'active' => true,
            ],
            [
                'name' => 'Camisa Arsenal Clássica',
                'team' => 'Arsenal',
                'season' => 'Coleção histórica',
                'description' => 'Camisa vermelha e branca inspirada nos mantos tradicionais dos Gunners de Londres.',
                'price' => 209.90,
                'compare_price' => 249.90,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/6a/Kit_body_arsenal1415g%28a%29.png',
                'sizes' => ['P', 'M', 'G', 'GG'],
                'stock' => 13,
                'featured' => false,
                'active' => true,
            ],
        ];

        Product::query()->delete();

        foreach ($products as $product) {
            Product::query()->create($product);
        }
    }
}
