<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Permissions\Entities\Permission;

class PermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('permissions')->insert([
            [
                'can_create' => true,
                'can_read'   => true,
                'can_update' => true,
                'can_delete' => true
            ],
            [
                'can_read'   => true
                // other, default false
            ]
        ]);
    }
}
