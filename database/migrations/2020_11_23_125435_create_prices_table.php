<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->references('id')->on('currencies')->cascadeOnUpdate();
            $table->foreignId('to')->references('id')->on('currencies')->cascadeOnUpdate();
            $table->decimal('mid', 16, 8, true);
            $table->decimal('bid', 16, 8, true);
            $table->decimal('ask', 16, 8, true);
            $table->decimal('last_price', 16, 8, true);
            $table->decimal('low', 16, 8, true);
            $table->decimal('high', 16, 8, true);
            $table->decimal('volume', 16, 8, true);
            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
