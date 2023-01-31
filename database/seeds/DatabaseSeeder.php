<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'nom' => 'Admin',
                'email' => 'admin@tersea.com',
                'password' => bcrypt('adminIsHere123'),
                'address' => 'Tangier, Morocco',
                'phone' => '+212657576739',
                'date_of_birth' => Carbon::parse('1999-07-17')->format('Y-m-d'),
                'is_admin' => true,
                'verified' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]
        );
        // $this->call(UserSeeder::class);
    }
}
