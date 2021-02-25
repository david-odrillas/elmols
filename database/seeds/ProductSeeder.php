<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Unit;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $maiz = Product::create([
        'name' => 'maiz cubano'
      ]);
      $maiz->units()->create([
        'volumen' => 'quintal',
        'price' =>  80,
        'quantity' => 100,
        'gain' => 7,
        'accumulate' => 1,
        'sponsor' => 1,
        'supsponsor' => .5
      ]);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  21,
        'quantity' => 25,
        'gain' => 2.8,
        'accumulate' => 1,
        'sponsor' => .6,
        'supsponsor' => .2
      ]);
      $maiz = Product::create([
        'name' => 'maiz criollo'
      ]);
      $maiz->units()->create([
        'volumen' => 'quintal',
        'price' =>  155,
        'quantity' => 100,
        'gain' => 15,
        'accumulate' => 1,
        'sponsor' => 2,
        'supsponsor' => 1
      ]);
      $amarillo = Product::create([
        'name' => 'H. Amarillo C.'
      ]);
      $amarillo->units()->create([
        'volumen' => 'quintal',
        'price' =>  90,
        'quantity' => 100,
        'gain' => 14,
        'accumulate' => 1,
        'sponsor' => 2,
        'supsponsor' => 1
      ]);
      $amarillo->units()->create([
        'volumen' => 'arroba',
        'price' => 25,
        'quantity' => 25,
        'gain' => 6,
        'accumulate' => 1,
        'sponsor' => 1,
        'supsponsor' => .5
      ]);
    }
}
