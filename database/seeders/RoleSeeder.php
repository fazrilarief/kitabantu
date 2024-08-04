<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner',
        ]);

        $fundraiserRole = Role::create([
            'name' => 'fundraiser',
        ]);

        $userOwner = User::create([
            'name' => 'Fazril Arief Nugraha',
            'avatar' => 'avatars/default-avatar.png',
            'email' => 'fazrilarief@gmail.com',
            'password' => bcrypt('fazril123'),
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
