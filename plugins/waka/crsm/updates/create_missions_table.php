<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateMissionsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_missions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('is_template')->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('qty', 10, 2)->default(1);
            $table->double('amount', 10, 2)->default(100);
            $table->double('total', 15, 2)->nullable();
            $table->double('final_total', 15, 2)->nullable();
            $table->integer('period_id')->unsigned()->nullable();
            $table->integer('sort_order')->default(0);
        });

        // Schema::create('waka_crsm_missions_projects', function($table)
        // {
        //     $table->engine = 'InnoDB';
        //     $table->integer('mission_id')->unsigned();
        //     $table->integer('project_id')->unsigned();
        //     // $table->boolean('own_amount')->default(false);
        //     $table->double('amount', 10, 2)->nullable();
        //     // $table->boolean('own_description')->default(false);
        //     $table->text('description')->nullable();
        //     $table->double('qty', 5, 2)->nullable();
        //     $table->primary(['mission_id', 'project_id'], 'mission_project');
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_missions');
    }
}
