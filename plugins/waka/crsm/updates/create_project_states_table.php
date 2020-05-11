<?php namespace Waka\Crsm\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProjectStatesTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_project_states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_running')->default(0);
                                    
            $table->integer('sort_order')->default(0);
                                    
            $table->softDeletes();
                        
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_project_states');
    }
}
