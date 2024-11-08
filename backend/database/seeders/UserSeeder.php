<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('users')->delete();
        $data = [
            'username' => 'Maniruzzaman Akash',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456')
        ];
        User::create($data);

        
        User::factory(20)->create(['role' => 'user']);
    }
}
