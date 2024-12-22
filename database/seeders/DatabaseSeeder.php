<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\Profile;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'isadmin' => 1,
            'code_auth' => null,
        ]);
        
        $balance = new UserBalance();
        $user->balance()->save($balance);

        $profile = new Profile();
        $user->profile()->save($profile);
        
    }
}
