<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Seeder;

class SeedContactsClients extends Seeder
{
    public function run()
    {
        /**
         * IMPORT DES SECTEURS, CLIENTS ET CONTACTS
         */
        // Db::table('waka_crsm_sectors')->truncate();
        // Db::table('waka_crsm_clients')->truncate();
        // Db::table('waka_crsm_contacts')->truncate();
        // echo 'Chargement du classeur CRSM Import' . PHP_EOL;
        // Excel::import(new \Waka\Crsm\Classes\Imports\ClasseurCrsmImport, plugins_path('waka/crsm/updates/excels/start_crsm.xlsx'));

        // Db::table('waka_crsm_sectors')->truncate();
        // Excel::import(new \Waka\Crsm\Classes\Imports\SectorImport, plugins_path('waka/crsm/updates/excels/start_secteurs.xlsx'));

        // Db::table('waka_crsm_clients')->truncate();
        // Excel::import(new \Waka\Crsm\Classes\Imports\ClientImport, plugins_path('waka/crsm/updates/excels/start_clients.xlsx'));

        // Db::table('waka_crsm_contacts')->truncate();
        // Excel::import(new \Waka\Crsm\Classes\Imports\ClasseurCrsmImport, plugins_path('waka/crsm/updates/excels/start_crsm.xlsx'));
        $sql = plugins_path('waka/crsm/updates/sql/crsm.sql');
        DB::unprepared(file_get_contents($sql));
    }

}
