<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Assistance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('assistance', function (Blueprint $table) {
        $table->increments('id_assistance');
        $table->integer('id_school');
        $table->integer('id_user');
        $table->text('ast_description');
        $table->dateTime('ast_proposed_datetime')->nullable();
        $table->string('ast_student_level')->nullable();
        $table->integer('ast_no_of_student')->nullable();
        $table->enum('ast_resource_type', ['mobile_device', 'personal_computer','networking_equipment'])->nullable();
        $table->integer('ast_no_of_resource')->nullable();
        $table->enum('ast_type', ['tutorial', 'resource']);
        $table->enum('ast_status', ['new', 'closed'])->default('new');
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('assistance');
    }
}
