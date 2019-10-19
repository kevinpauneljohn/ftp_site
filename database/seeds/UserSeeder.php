<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;

        $user->firstname = "John Kevin";
        $user->middlename = "Pama";
        $user->lastname = "Paunel";
        $user->username = "kevinpauneljohn";
        $user->email = "johnkevinpaunel@gmail.com";
        $user->password = bcrypt("123");
        $user->active = 0;
        $user->assignRole('super admin');

        $user->save();
    }
}
