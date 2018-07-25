<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddAdditionalInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company')->after('email');
            $table->text('address')->after('company');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('zip')->after('state');
            $table->string('country')->after('zip');
            $table->string('phone')->after('country');
            $table->string('web')->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('country');
            $table->dropColumn('phone');
            $table->dropColumn('web');
        });
    }
}
