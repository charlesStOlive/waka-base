<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Seeder;

class SeedImportExport extends Seeder
{
    public function run()
    {
        Db::table('waka_importexport_config_exports')->truncate();
        Db::table('waka_importexport_config_imports')->truncate();
        Db::table('waka_configexports_users')->truncate();
        Db::table('waka_configexports_users')->truncate();

        echo 'Chargement du sql configExport' . PHP_EOL;
        $sql = plugins_path('waka/crsm/updates/sql/waka_importexport_config_exports.sql');
        DB::unprepared(file_get_contents($sql));

        echo 'Chargement du sql  ConfigImport' . PHP_EOL;
        $sql = plugins_path('waka/crsm/updates/sql/waka_importexport_config_imports.sql');
        DB::unprepared(file_get_contents($sql));

        echo 'Chargement du sql user export' . PHP_EOL;
        $sql = plugins_path('waka/crsm/updates/sql/waka_configexports_users.sql');
        DB::unprepared(file_get_contents($sql));

        // echo 'Chargement du sql user import' . PHP_EOL;
        // $sql = plugins_path('waka/crsm/updates/sql/waka_configimports_users.sql');
        // DB::unprepared(file_get_contents($sql));

    }

}
