<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('invoice_items', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('invoice_id')->unsigned();
            $table->integer('tax_rate_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('display_order')->default(0);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax_total', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->index('invoice_id');
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
        Schema::dropIfExists('invoice_items');
    }
}
