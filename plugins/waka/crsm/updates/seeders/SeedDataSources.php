<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Seeder;

class SeedDataSources extends Seeder
{
    public function run()
    {
        /**
         * CONFIGURATION DES FICHIERS DATA SOURCE
         */
        Db::table('waka_utils_data_sources')->truncate();
        $sql = plugins_path('waka/crsm/updates/sql/waka_utils_data_sources.sql');
        DB::unprepared(file_get_contents($sql));
    }

}
