<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', static function (Blueprint $table) {
            $table->id();
            $table->string('iso_code', 3);
        });

        // Add initial values
        $table = DB::table('currencies');
        foreach (['USD', 'BTC'] as $iso_code) {
            $table->insert(compact('iso_code'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
