<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $journalistRole = Role::firstOrCreate(['name' => 'journalist']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Super Admin (News Editorial)
        $admin = User::firstOrCreate(
            ['email' => 'admin@news.com'],
            [
                'name' => 'Aditya Sharma',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80',
                'bio' => 'Editor-in-Chief & Founder. 20+ years of investigative journalism across South Asia and global affairs.',
                'is_active' => true,
            ]
        );
        $admin->assignRole($adminRole);

        // Demo Administrator (admin@demo.com / password)
        $demoAdmin = User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Admin Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=300&q=80',
                'bio' => 'System Administrator with full editorial and resource management access.',
                'is_active' => true,
            ]
        );
        $demoAdmin->assignRole($adminRole);

        // Senior Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@news.com'],
            [
                'name' => 'Pooja Iyer',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                'bio' => 'Executive Editor. Covering economic policy, foreign relations, and technological transformation.',
                'is_active' => true,
            ]
        );
        $editor->assignRole($editorRole);

        // Staff Journalist
        $journalist = User::firstOrCreate(
            ['email' => 'journalist@news.com'],
            [
                'name' => 'Vikram Malhotra',
                'password' => Hash::make('password'),
                'role' => 'journalist',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'bio' => 'Special Correspondent reporting on national security, elections, and ground realities.',
                'is_active' => true,
            ]
        );
        $journalist->assignRole($journalistRole);

        // General Reader / Subscriber
        $reader = User::firstOrCreate(
            ['email' => 'reader@news.com'],
            [
                'name' => 'Ananya Sen',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80',
                'bio' => 'Avid reader and verified subscriber.',
                'is_active' => true,
            ]
        );
        $reader->assignRole($userRole);
    }
}
