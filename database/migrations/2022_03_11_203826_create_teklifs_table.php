<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeklifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teklifs', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->integer('musteriId');
            $table->double('fiyat');
            $table->text('aciklama')->nullable();
            $table->integer('status')->comment('0 acik teklif 1 onaylanmis teklif');
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
        Schema::dropIfExists('teklifs');
    }
}
