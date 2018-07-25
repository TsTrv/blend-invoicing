<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            
            $table->string('name');
            $table->decimal('percent', 5, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

        });

        DB::table('taxes')->insert([
            'name' => 'DDV 0%',
            'percent' => '0'
        ]);

        DB::table('taxes')->insert([
            'name' => 'DDV 5%',
            'percent' => '5'
        ]);

        DB::table('taxes')->insert([
            'name' => 'DDV 18%',
            'percent' => '18'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}
