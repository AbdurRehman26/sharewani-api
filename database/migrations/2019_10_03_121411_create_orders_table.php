<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('product_id');
			$table->bigInteger('user_id');
			$table->bigInteger('address_id');
			$table->boolean('number_of_days')->default(3);
			$table->boolean('status')->default(0);
			$table->date('from_date')->nullable();
			$table->date('to_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->boolean('number_of_items')->nullable()->default(1);
			$table->unique(['product_id','user_id','status','from_date','to_date'], 'product_user_status_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
