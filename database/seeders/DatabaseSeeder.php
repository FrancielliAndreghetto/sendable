<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $partner = Partner::factory()->create([
            'name' => 'Parceiro Teste',
            'slug' => 'parceiro-teste',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'partner_id' => $partner->id,
        ]);
    }
}
