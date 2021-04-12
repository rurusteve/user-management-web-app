<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Permissions\Entities\Permission;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('roles')->insert([
            [
                'permission_id'   => 1,
                'role_name'       => 'Admin',
                'role_code'       => 'ADM'
            ],
            [
                'permission_id'   => 2,
                'role_name'       => 'Staff',
                'role_code'       => 'STF'
            ]
        ]);
    }
}
