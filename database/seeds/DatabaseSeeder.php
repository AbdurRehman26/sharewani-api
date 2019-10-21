<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::create([
            'name' => 'Admin',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'admin@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'manager@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
        ]);
        $editor = User::create([
            'name' => 'Editor',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'editor@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
        ]);
        $user = User::create([
            'name' => 'User',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'user@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
        ]);
        $visitor = User::create([
            'name' => 'Visitor',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'visitor@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $editorRole = Role::findByName(\App\Laravue\Acl::ROLE_EDITOR);
        $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
        $visitorRole = Role::findByName(\App\Laravue\Acl::ROLE_VISITOR);
        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $editor->syncRoles($editorRole);
        $user->syncRoles($userRole);
        $visitor->syncRoles($visitorRole);

        $this->call(UsersTableSeeder::class);


        $this->call(CategoryTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(ColorTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(FabricAgeTableSeeder::class);
        $this->call(SizeTableSeeder::class);

        $this->call(ProductTableSeeder::class);
        $this->call(AssociateProductsTableSeeder::class);

        $this->call(OrderTableSeeder::class);

    }
}
