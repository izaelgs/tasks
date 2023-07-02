<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Izael Gonçalves da Silva',
            'email' => 'izael.dev@gmail.com',
            'password' => Hash::make('senha'),
        ]);

        // Criação de mais usuários de exemplo
        User::factory()
            ->count(10)
            ->hasTeams(1)
            ->create();
    }
}
