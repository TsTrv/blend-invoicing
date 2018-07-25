<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCurrencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('symbol');
            $table->string('placement');
            $table->string('decimal');
            $table->string('thousands');
            
            $table->index('code')->unique();
            
            $table->timestamps();
            $table->softDeletes();

        });

        DB::table('currencies')->insert([
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'placement' => 'before',
            'decimal' => '.',
            'thousands' => ',',
        ]);
        DB::table('currencies')->insert([
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'placement' => 'before',
            'decimal' => '.',
            'thousands' => ',',
        ]);
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
