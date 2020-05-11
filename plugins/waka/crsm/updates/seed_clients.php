<?php namespace Waka\Crsm\Updates;

use Seeder;

class SeedClients extends Seeder
{
    public function run()
    {
        $this->call('Waka\Crsm\Updates\Seeders\SeedContactsClients');

    }
}
