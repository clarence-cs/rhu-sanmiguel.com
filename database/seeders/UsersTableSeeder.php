<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'RHU-Personel',
                'email' => 'rhusanmiguel@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$jNAzwemEmFedJV0e7WD2T.NhcqFU07OnhXwzaEUPLPPzP/MApP4y.',
                'remember_token' => 'bswDbz9c2mbukqAQM85q8i69RyGEhPM6aKQbOH4FNXqsEjbHSwKSqAK3Qouf',
                'created_at' => '2026-07-01 12:45:06',
                'updated_at' => '2026-07-01 12:45:06',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Rhu-personal',
                'email' => 'cvtapit@catsu.edu.ph',
                'email_verified_at' => NULL,
                'password' => '$2y$12$zS8DAIqxj1UIq6dLunFM5.0Z7fgw5TkLDjK6zz0EX4kSpvAJWweLq',
                'remember_token' => NULL,
                'created_at' => '2026-07-02 04:09:23',
                'updated_at' => '2026-07-02 04:09:23',
            ),
        ));
        
        
    }
}