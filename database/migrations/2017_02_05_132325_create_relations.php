<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('currency_code')->references('code')->on('currencies')->onDelete('cascade');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('currency_code')->references('code')->on('currencies')->onDelete('cascade');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');;
            $table->foreign('tax_rate_id')->references('id')->on('taxes')->onDelete('cascade');;
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');;
            $table->foreign('tax_rate_id')->references('id')->on('taxes')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_user_id_foreign');
            $table->dropForeign('invoices_client_id_foreign');
            $table->dropForeign('invoices_currency_code_foreign');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign('quotes_user_id_foreign');
            $table->dropForeign('quotes_client_id_foreign');
            $table->dropForeign('quotes_currency_code_foreign');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropForeign('invoice_items_invoice_id_foreign');
            $table->dropForeign('invoice_items_tax_rate_id_foreign');
        });

        Schema::table('quote_items', function (Blueprint $table) {
            $table->dropForeign('quote_items_quote_id_foreign');
            $table->dropForeign('quote_items_tax_rate_id_foreign');
        });
    }
}
