<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::count()){
            
            User::query()->create([
                'email'             => 'admin@ISoket.com',
                'name'              => 'admin',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
            ]);
        }
        
    }
}
