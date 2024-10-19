<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User; // Import User model

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $studentRole = Role::create([
            'name' => 'student'
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);

        $userOwner = User::create([
            'name' => 'Mustofa Husni Sanoval',
            'occupation' => 'Educator',
            'avatar' => 'images/default-avatar.png',
            'email' => 'sanomush@owner.com',
            'password' => bcrypt('Lolipop1001')
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
