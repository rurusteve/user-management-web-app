<?php

namespace Modules\Users\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Roles\Database\Seeders\RolesDatabaseSeeder;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->insert([
            [
                'role_id'           => 1,
                'password'          => Hash::make('unique'),
                'first_name'        => 'Damianus',
                'last_name'         => 'Kristianto',
                'username'          => 'damikris',
                'email'             => 'dkristianto@deloitte.com',
                'phone_number'      => 82121334383,
                'email_verified_at' => Carbon::now()
            ],
            [
                'role_id'           => 2,
                'password'          => Hash::make('unique'),
                'first_name'        => 'Anak',
                'last_name'         => 'Manies',
                'username'          => 'anies',
                'email'             => 'anak@manis.com',
                'phone_number'      => 8880001688,
                'email_verified_at' => Carbon::now()
            ],
            [
                'role_id'           => 3,
                'password'          => Hash::make('unique'),
                'first_name'        => 'Elon',
                'last_name'         => 'Musk',
                'username'          => 'maskelon',
                'email'             => 'founder@tesla.car',
                'phone_number'      => 14045,
                'email_verified_at' => Carbon::now()
            ],
            [
                'role_id'           => 4,
                'password'          => Hash::make('unique'),
                'first_name'        => 'Jeff',
                'last_name'         => 'Bezos',
                'username'          => 'amazoo',
                'email'             => 'bezos@aws.staff',
                'phone_number'      => rand(9, 9),
                'email_verified_at' => Carbon::now()
            ]
        ]);

    }
}
