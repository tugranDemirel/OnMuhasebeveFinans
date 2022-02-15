<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusterilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musterilers', function (Blueprint $table) {
            $table->id();
            $table->integer('musteriTipi')->default(0)->comment('0 bireysel musteri, 1 kurumsl musteri');
            $table->string('photo')->nullable();
// bİreysel musteriler iicin gerekli olan alanlar
            $table->string('ad')->nullable();
            $table->string('soyad')->nullable();
            $table->date('dogumTarihi')->nullable();
            $table->string('tc')->nullable();
// Kurumsal musteriler icin gerekli alanlar
            $table->string('firmaAdi')->nullable();
            $table->string('vergiNumarasi')->nullable();
            $table->string('vergiDairesi')->nullable();

            $table->string('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('musterilers');
    }
}
