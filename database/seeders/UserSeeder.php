<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criação de um usuário de exemplo
        $izael = User::create([
            'name' => 'Izael Gonçalves da Silva',
            'email' => 'izael.dev@gmail.com',
            'password' => Hash::make('senha123'),
        ]);

        // Criação de mais usuários de exemplo
        User::factory()
            ->count(10)
            ->hasTeams(1)
            ->create()
            ->each(function ($user) {
                Category::create([
                    'title'         => 'Personal Projects',
                    'description'   => 'Here you can create personal projects',
                    'user_id'       => $user->id,
                ]);
            });

        // Criar uma categoria relacionada ao usuário Izael
        $categoria = Category::create([
            'title'         => 'Personal Projects',
            'description'   => 'Here you can create personal projects',
            'user_id'       => $izael->id,
        ]);
    }
}
