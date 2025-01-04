<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
        $this->call([
            UserSeeder::class,
        ]);

        DB::table('genres')->insert([
            ['name' => 'Acción'],
            ['name' => 'Aventura'],
            ['name' => 'Ciencia ficción'],
            ['name' => 'Drama'],
            ['name' => 'Comedia'],
            ['name' => 'Terror'],
            ['name' => 'Fantasía'],
            ['name' => 'Animación'],
            ['name' => 'Documental'],
            ['name' => 'Musical'],
            ['name' => 'Romance'],
            ['name' => 'Crimen'],
            ['name' => 'Misterio'],
            ['name' => 'Guerra'],
            ['name' => 'Familia'],
            ['name' => 'Historia'],
            ['name' => 'Western'],
            ['name' => 'Suspense'],
            ['name' => 'Infantil'],
            ['name' => 'Biografía'],
            ['name' => 'Deporte'],
            ['name' => 'Música'],
            ['name' => 'Superhéroes'],
            ['name' => 'Política'],
        ]);
    }
}
