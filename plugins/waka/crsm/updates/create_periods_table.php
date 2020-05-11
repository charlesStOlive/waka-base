<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreatePeriodsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_periods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('repeat');
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_periods');
    }
}
