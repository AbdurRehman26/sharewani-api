<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('address');
            $table->text('address_secondary')->nullable();
            $table->string('nearest_check_point')->nullable();
            
            $table->bigInteger('user_id');
            $table->bigInteger('city_id');
            
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
        Schema::dropIfExists('user_addresses');
    }
}
