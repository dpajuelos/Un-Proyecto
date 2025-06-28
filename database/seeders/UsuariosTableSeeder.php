<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('usuarios')->insert([
            'nombre_usuario' => 'dilber',
            'contrasena_hash' => bcrypt('dilber123'),
        ]);
        
        DB::table('usuarios')->insert([
            'nombre_usuario' => 'Kiyoshi',
            'contrasena_hash' => bcrypt('user123'),
        ]); 
        DB::table('usuarios')->insert([
            'nombre_usuario' => 'Kope',
            'contrasena_hash' => bcrypt('admin'),
        ]); 
    }
}
