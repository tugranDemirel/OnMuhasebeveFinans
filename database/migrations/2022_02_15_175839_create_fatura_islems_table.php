<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturaIslemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fatura_islems', function (Blueprint $table) {
            $table->id();
            $table->integer('faturaId');
            $table->integer('kalemId');
            $table->integer('urunId');
            $table->integer('miktar');
            $table->double('fiyat');
            $table->integer('kdv')->default(0);
            $table->double('araToplam');
            $table->double('kdvToplam');
            $table->double('genelToplam');
            $table->text('text');
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
        Schema::dropIfExists('fatura_islems');
    }
}
