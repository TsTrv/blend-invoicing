<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuoteItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_items', function (Blueprint $table) {

            $table->increments('id')->unsigned();

            $table->integer('quote_id')->unsigned();
            $table->integer('tax_rate_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('display_order')->default(0);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_total', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->index('quote_id');
            $table->index('tax_rate_id');
            $table->index('display_order');

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
        Schema::dropIfExists('quote_items');
    }
}
