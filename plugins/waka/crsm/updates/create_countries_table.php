<?php namespace Waka\Crsm\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code');
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_countries');
    }
}
