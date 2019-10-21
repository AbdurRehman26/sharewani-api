<?php

use Illuminate\Database\Seeder;
use App\Laravue\Acl;
use App\Laravue\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userList = [
            "Ali",
            "Talmeez",
            "Arsal",
            "Kazmi",
            "Nabeel",
            "Waqas",
            "Hannan",
        ];

        foreach ($userList as $fullName) {
            $name = str_replace(' ', '.', $fullName);
            $roleName = \App\Laravue\Faker::randomInArray([
                Acl::ROLE_MANAGER,
                Acl::ROLE_EDITOR,
                Acl::ROLE_USER,
                Acl::ROLE_VISITOR,
            ]);
            $user = \App\Laravue\Models\User::create([
                'name' => $fullName,
                'phone_number' => mt_rand(100000, 999999),
                'email' => strtolower($name) . '@sharewani.com',
                'password' => \Illuminate\Support\Facades\Hash::make('sharewani123!@#'),
            ]);

            $role = Role::findByName($roleName);
            $user->syncRoles($role);
        }
    }
}
