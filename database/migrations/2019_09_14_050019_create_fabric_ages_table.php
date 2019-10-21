<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricAgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabric_ages', function (Blueprint $table) {

            $table->integer('id', true);
            $table->string('name')->unique('name_UNIQUE');
            $table->timestamps();
            $table->string('deleted_at', 6)->nullable();
            $table->integer('parent_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fabric_ages');
    }
}
