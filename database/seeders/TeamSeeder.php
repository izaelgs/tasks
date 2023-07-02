<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criação de um usuário de exemplo
        Team::create([
            'user_id'       => '1',
            'name'          => 'Time Teste',
            'personal_team' => '1',
        ]);
    }
}
