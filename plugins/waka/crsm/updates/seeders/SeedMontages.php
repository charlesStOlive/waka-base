<?php namespace Waka\Crsm\Updates\Seeders;

use Seeder;

class SeedMontages extends Seeder
{
    public function run()
    {
        \Db::table('waka_cloudis_montages')->truncate();
        $sql = plugins_path('waka/crsm/updates/sql/waka_cloudis_montages.sql');
        \DB::unprepared(file_get_contents($sql));
    }

}
