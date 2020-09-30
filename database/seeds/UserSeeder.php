<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // id 2
      $ci = '10321881';
      User::create([
        'name' => 'Francisco Mamani Soto',
        'ci'   => $ci,
        'cell' => '61742901',
        'email'=> $ci.'@elmols.com',
        'address' => 'Barrio Israel Z. Karapunku',
        'password' => Hash::make($ci),
        'user_id' =>1
      ]);
      //id 3
      $ci ='1146745';
      User::create([
        'name' => 'Marina Alvis Villacorta',
        'ci'   => $ci,
        'cell' => '65256584',
        'email'=> $ci.'@elmols.com',
        'address' => 'Barrio Alto Sucre',
        'password' => Hash::make($ci),
        'user_id' =>1
      ]);
      //id 4
      $ci ='5493483';
      User::create([
        'name' => 'Hugo Loayza Reyes Ortis',
        'ci'   => $ci,
        'cell' => '79318928',
        'email'=> $ci.'@elmols.com',
        'address' => 'Barrio Alto Sucre',
        'password' => Hash::make($ci),
        'user_id' =>1
      ]);
      //id 5
      $ci ='5643163';
      User::create([
        'name' => 'Faustina Saugua',
        'ci'   => $ci,
        'cell' => '74403012',
        'email'=> $ci.'@elmols.com',
        'address' => 'Barrio Alto Sucre',
        'password' => Hash::make($ci),
        'user_id' =>1
      ]);
      // id 6
      $ci ='10401936';
      User::create([
        'name' => 'Jorge Luis Garcia Sanchez',
        'ci'   => $ci,
        'cell' => '78698149',
        'email'=> $ci.'@elmols.com',
        'address' => 'Barrio Alto Sucre',
        'password' => Hash::make($ci),
        'user_id' =>1
      ]);




    }
}
