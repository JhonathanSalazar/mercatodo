<?php

use App\Entities\User;
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
        $buyer->name = 'Jhon';
        $buyer->email = 'buyer@gmail.com';
        $buyer->password = bcrypt('123123');
        $buyer->save();

        $buyer->assignRole($buyerRole);

        $buyer1 = new User;
        $buyer1->name = 'Ana';
        $buyer1->email = 'buyer1@gmail.com';
        $buyer1->password = bcrypt('123123');
        $buyer1->save();

        $buyer1->assignRole($buyerRole);

        $buyer2 = new User;
        $buyer2->name = 'Ana';
        $buyer2->email = 'buyer2@gmail.com';
        $buyer2->password = bcrypt('123123');
        $buyer2->save();

        $buyer2->assignRole($buyerRole);
    }
}
