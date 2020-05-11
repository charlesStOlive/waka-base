<?php namespace Waka\Crsm\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMissionTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_mission_templates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('amount', 10, 2)->default(100);               
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_mission_templates');
    }
}
