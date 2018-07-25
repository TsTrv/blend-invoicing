<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {

            $table->increments('id')->unsigned();

            $table->integer('user_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('status_id');
            $table->date('due_date');
            $table->date('issued_date');

            $table->string('number');
            $table->text('terms')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->string('currency_code');

            $table->index('user_id');
            $table->index('client_id');
            $table->index('status_id');

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
        Schema::dropIfExists('quotes');
        
    }
}
