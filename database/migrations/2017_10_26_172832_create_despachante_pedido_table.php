<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDespachantePedidoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('despachante_pedido', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('despachante_pedido_persona_id_foreign');
			$table->integer('pedido_id')->unsigned()->index('despachante_pedido_pedido_id_foreign');
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
		Schema::drop('despachante_pedido');
	}

}
