<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\Product::factory(50)->create();
          DB::table('users')->insert([
            'name'=>'Shahroz',
            'email' => 'Shah.Shahrozkhanshah@gmail.com',
            'user_type'=>'super',
            'password' => '$2y$10$QKSScyTrSIG/ku3zDvQj1uCc8xqzOl3kd1nrzBmuVbzKDlaRmZdd.',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

         DB::table('roles')->insert([
            'name' => 'super',
            'guard_name' => 'web',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id'=>1,
        ]);
    }
}
