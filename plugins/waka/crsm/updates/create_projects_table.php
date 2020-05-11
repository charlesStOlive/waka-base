<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('client_id')->unsigned();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->integer('cp_id')->unsigned();
            $table->integer('project_state_id')->unsigned();
            $table->double('total', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->integer('nb_user_pot')->nullable();
            $table->date('closed_at')->nullable();
            $table->date('closed_presvision_at')->nullable();
            $table->boolean('is_ex')->default(false);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_projects');
    }
}
