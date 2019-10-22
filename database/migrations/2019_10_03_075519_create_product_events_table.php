<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_events', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('product_id');
			$table->integer('event_id');
			$table->timestamps();
			$table->unique(['product_id','event_id'], 'product_event_unique');
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
		Schema::drop('product_events');
	}

}
