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
        'name' => 'maiz'
      ]);
      $maiz->units()->create([
        'volumen' => 'cuartilla',
        'price' =>  5.5,
        'quantity' => 6,
        'sponsor' => .25,
        'supsponsor' => .2
      ]);
      $maiz->units()->create([
        'volumen' => 'arroba',
        'price' =>  10,
        'quantity' => 25,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $trigo = Product::create([
        'name' => 'trigo'
      ]);
      $trigo->units()->create([
        'volumen' => 'cuartilla',
        'price' =>  6,
        'quantity' => 6,
        'sponsor' => .25,
        'supsponsor' => .2
      ]);
      $trigo->units()->create([
        'volumen' => 'arroba',
        'price' =>  11,
        'quantity' => 25,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
      $mani = Product::create([
        'name' => 'mani'
      ]);
      $mani->units()->create([
        'volumen' => 'cuartilla',
        'price' =>  7,
        'quantity' => 6,
        'sponsor' => .25,
        'supsponsor' => .2
      ]);
      $mani->units()->create([
        'volumen' => 'arroba',
        'price' =>  12,
        'quantity' => 25,
        'sponsor' => 1,
        'supsponsor' => .7
      ]);
    }
}
