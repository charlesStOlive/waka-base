<?php namespace Waka\Crsm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_crsm_contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('civ')->default('Mme/M.');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('tel_perso')->nullable();
            $table->string('key')->nullable();
            $table->integer('client_id')->nullable();
            $table->text('content_linkedin')->nullable();
            $table->text('content_email')->nullable();
            $table->text('content_word')->nullable();
            $table->text('content_lp')->nullable();
            $table->boolean('is_ex')->default(false);
            //
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_crsm_contacts');
    }
}
