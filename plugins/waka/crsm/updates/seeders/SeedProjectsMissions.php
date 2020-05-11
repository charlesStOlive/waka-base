<?php namespace Waka\Crsm\Updates\Seeders;

use DB;
use Excel;
use Seeder;

class SeedProjectsMissions extends Seeder
{
    public function run()
    {
        Db::table('waka_crsm_projects')->truncate();
        Db::table('waka_crsm_missions')->truncate();
        Db::table('waka_crsm_project_states')->truncate();

        echo 'Chargement du classeur CRM PROJECT MISSION' . PHP_EOL;
        Excel::import(new \Waka\Crsm\Classes\Imports\ClasseurCrsmProjectMissionImport, plugins_path('waka/crsm/updates/excels/start_crsm_missions.xlsx'));
    }

}
