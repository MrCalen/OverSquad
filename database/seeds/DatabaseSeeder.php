<?php

use Illuminate\Database\Seeder;

use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");

        $user = new User();
        $user->name = "Admin";
        $user->email = "dagues_p@yaka.epita.fr";
        $user->admin = 1;
        $user->password = \Illuminate\Support\Facades\Hash::make(env('DB_PWD', 'password'));
        $user->gametag = env("DB_TAG");

        $user->save();

        $user = new User();
        $user->name = "Root";

        $user->email = "dagues_p@acu.epita.fr";
        $user->password = \Illuminate\Support\Facades\Hash::make(env('DB_PWD', 'password'));
        $user->gametag = env("DB_TAG");
        $user->save();
    }
}
