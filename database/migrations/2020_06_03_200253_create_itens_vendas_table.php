<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_vendas', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_vendida');
            $table->bigInteger('id_produto')->unsigned();
            $table->foreign('id_produto')
                ->references('id')
                ->on('produtos')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->bigInteger('id_venda')->unsigned();
            $table->foreign('id_venda')
                ->references('id')
                ->on('vendas')
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->date('data_venda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_vendas');
    }
}
