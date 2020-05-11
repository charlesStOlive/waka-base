<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Seeder;

class SeedBackendUsers extends Seeder
{
    public function run()
    {
        Db::table('backend_users')->truncate();
        $sql = plugins_path('waka/crsm/updates/sql/backend_users.sql');
        DB::unprepared(file_get_contents($sql));

        Db::table('backend_user_roles')->truncate();
        $sql = plugins_path('waka/crsm/updates/sql/backend_user_roles.sql');
        DB::unprepared(file_get_contents($sql));

    }

}
