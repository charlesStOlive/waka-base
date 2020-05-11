<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            //
            $table->string('name');
            $table->string('slug');
            $table->integer('sector_id')->unsigned();

            $table->boolean('cloudi_ready')->default(false);

            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();

            $table->text('description')->nullable();

            $table->integer('nb_collab')->nullable();

            $table->string('address')->nullable();
            $table->string('cp')->nullable();
            $table->string('city')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->integer('country_id')->unsigned();
            $table->boolean('is_ex')->default(false);
            //
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_clients');
    }
}
