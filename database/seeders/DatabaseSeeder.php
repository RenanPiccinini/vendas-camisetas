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
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/01/Boateng_warm_up_Real_Madrid-Milan_2012.jpg',
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
                'image_url' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/d/d0/Manchester_City_dressing_room_2022.jpg/1280px-Manchester_City_dressing_room_2022.jpg',
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
                'image_url' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/d/df/Psg-2008-2009-away-shirt.jpg/960px-Psg-2008-2009-away-shirt.jpg',
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
                'image_url' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/4/42/Arsenal_shirts_worn_by_former_players.jpg/960px-Arsenal_shirts_worn_by_former_players.jpg',
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
