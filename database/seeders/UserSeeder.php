<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'cashier']);
        $role2 = Role::create(['name' => 'customer']);

        // Cashier
        $user = User::create([
            'id' => 1,
            "name" => "Cashier ABC",
            "email" => "cashierabc@mail.com",
            "gender" => "male",
            "place_of_birth" => "Jakarta",
            "date_of_birth" => "1990-04-22",
            "address" => "Jl. Sultan Agung No 1 Jakarta",
            "password" => bcrypt("abc123")
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'id' => 2,
            "name" => "Cashier DEF",
            "email" => "cashierdef@mail.com",
            "gender" => "female",
            "place_of_birth" => "Jakarta",
            "date_of_birth" => "1986-12-01",
            "address" => "Jl. D.I Pandjaitan 10 Jakarta",
            "password" => bcrypt("def123")
        ]);
        $user->assignRole($role1);

        // Customer
        $user = User::create([
            'id' => 3,
            "name" => "Aditia Saputra",
            "email" => "aditiasaputra@gmail.com",
            "gender" => "male",
            "place_of_birth" => "Jakarta",
            "date_of_birth" => "1986-12-01",
            "address" => "Jl. D.I Pandjaitan 10 Jakarta",
            "point" => 200,
            "password" => bcrypt("aditiasaputra")
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 4,
            "name" => "Adam Smith",
            "email" => "adamsmith@gmail.com",
            "gender" => "male",
            "place_of_birth" => "California",
            "date_of_birth" => "1980-10-20",
            "address" => "Jl. Gatot Subroto No. 75 Jakarta",
            "point" => 50,
            "password" => bcrypt("adamsmith")
        ]);
        $user->assignRole($role2);
    }
}
