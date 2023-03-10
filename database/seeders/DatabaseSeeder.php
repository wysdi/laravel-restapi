<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'user']);
        $role2 = Role::create(['name' => 'manager']);
        $role3 = Role::create(['name' => 'admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        \App\Models\User::factory()->create([
            'email' => 'user1@example.com',
        ])->each(function ($user, $role1) {
            $user->posts()->saveMany(Post::factory()->count(5)->make());
            $user->assignRole('user');
        });

        \App\Models\User::factory()->create([
            'email' => 'user2@example.com',
        ])->each(function ($user, $role1) {
            $user->posts()->saveMany(Post::factory()->count(5)->make());
            $user->assignRole('user');

        });




        $manager = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
        ]);
        $manager->assignRole($role2);

        $admin = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole($role3);
    }
}
