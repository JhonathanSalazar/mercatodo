<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('123123');
        $user->save();

        $user = new User;
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->password = bcrypt('123123');
        $user->save();
    }
}
