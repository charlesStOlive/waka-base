<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSectorsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_sectors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('nest_left')->unsigned()->nullable();
            $table->integer('nest_right')->unsigned()->nullable();
            $table->integer('nest_depth')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_sectors');
    }
}
