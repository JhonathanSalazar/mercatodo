<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Role::truncate();
        User::truncate();

        $adminRole = Role::create(['name' => 'Admin']);
        $buyerRole = Role::create(['name' => 'Buyer']);

        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('123123');
        $admin->save();

        $admin->assignRole($adminRole);

        $buyer = new User;
        $buyer->name = 'Buyer';
        $buyer->email = 'buyer@gmail.com';
        $buyer->password = bcrypt('123123');
        $buyer->save();

        $buyer->assignRole($buyerRole);

        $buyer1 = new User;
        $buyer1->name = 'Buyer';
        $buyer1->email = 'buyer1@gmail.com';
        $buyer1->password = bcrypt('123123');
        $buyer1->save();

        $buyer1->assignRole($buyerRole);
    }
}
