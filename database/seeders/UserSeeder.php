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
            "password" => "abc123"
        ]);
        $user->assignRole($role1);

        $user = User::create([
            'id' => 2,
            "name" => "Cashier DEF",
            "email" => "cashierdef@mail.com",
            "gender" => "female",
            "place_of_birth" => "Jawa Barat",
            "date_of_birth" => "1986-12-01",
            "address" => "Jl. D.I Pandjaitan 10 Jakarta",
            "password" => "def123"
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
            "password" => "aditiasaputra"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 4,
            "name" => "Adam Smith",
            "email" => "adamsmith@gmail.com",
            "gender" => "male",
            "place_of_birth" => "Sumatera Selatan",
            "date_of_birth" => "1980-10-20",
            "address" => "Jl. Gatot Subroto No. 75 Jakarta",
            "point" => 50,
            "password" => "adamsmith"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 5,
            "name" => "John Doe",
            "email" => "johndoe@gmail.com",
            "gender" => "male",
            "place_of_birth" => "Jawa Timur",
            "date_of_birth" => "1981-10-20",
            "address" => "Jl. Gatot Subroto No. 100 Bandung",
            "point" => 80,
            "password" => "johndoe"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 6,
            "name" => "Jane Doe",
            "email" => "janedoe@gmail.com",
            "gender" => "female",
            "place_of_birth" => "Lampung",
            "date_of_birth" => "1978-05-21",
            "address" => "Jl. Sultan Hasannudin No. 15 Makassar",
            "point" => 125,
            "password" => "janedoe"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 7,
            "name" => "Richard Smith",
            "email" => "richardsmith@gmail.com",
            "gender" => "male",
            "place_of_birth" => "Sulawesi Utara",
            "date_of_birth" => "1998-09-11",
            "address" => "Jl. Teuku Umar No. 65 Aceh",
            "point" => 145,
            "password" => "richardsmith"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 8,
            "name" => "Will Monroe",
            "email" => "willmonroe@gmail.com",
            "gender" => "male",
            "place_of_birth" => "Bali",
            "date_of_birth" => "1968-02-21",
            "address" => "Jl. Otto Iskandar No. 25 Semarang",
            "point" => 170,
            "password" => "willmonroe"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 9,
            "name" => "Michael Jordan",
            "email" => "michaeljordan@yahoo.com",
            "gender" => "male",
            "place_of_birth" => "Jawa Tengah",
            "date_of_birth" => "1968-04-15",
            "address" => "Jl. D.I Pandjaitan No. 74 Surabaya",
            "point" => 130,
            "password" => "michaeljordan"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 10,
            "name" => "Andrea Brooke",
            "email" => "andreabrooke@gmail.com",
            "gender" => "female",
            "place_of_birth" => "Banten",
            "date_of_birth" => "1978-12-10",
            "address" => "Jl. Cut Nyak Dien No. 74 Banten",
            "point" => 110,
            "password" => "andreabrooke"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 11,
            "name" => "Anna Williams",
            "email" => "annawilliams@hotmail.com",
            "gender" => "female",
            "place_of_birth" => "Sumatera Barat",
            "date_of_birth" => "1972-10-05",
            "address" => "Jl. Thamrin No. 12 Yogyakarta",
            "point" => 250,
            "password" => "annawilliams"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 12,
            "name" => "Nina Portman",
            "email" => "ninaportman@outlook.com",
            "gender" => "female",
            "place_of_birth" => "Yogyakarta",
            "date_of_birth" => "1980-09-19",
            "address" => "Jl. Ir. Djuanda No. 24 Malang",
            "point" => 190,
            "password" => "ninaportman"
        ]);
        $user->assignRole($role2);

        $user = User::create([
            'id' => 13,
            "name" => "Mike Lewis",
            "email" => "mikelewis@mail.com",
            "gender" => "male",
            "place_of_birth" => "Jambi",
            "date_of_birth" => "1990-10-29",
            "address" => "Jl. Imam Bondjol No. 43 Karawang",
            "point" => 240,
            "password" => "mikelewis"
        ]);
        $user->assignRole($role2);
    }
}
