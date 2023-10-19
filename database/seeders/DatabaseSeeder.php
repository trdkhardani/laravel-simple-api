<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Tridiktya Putra',
            'email' => 'tridiktya@mail.id',
            'password' => '$2a$12$DV4yc0ebJke3.7MZ30bhReqmvE5Z85eUaJJzwU9PRvvljV.MWAfdG' //tridik12
        ]);
    }
}
