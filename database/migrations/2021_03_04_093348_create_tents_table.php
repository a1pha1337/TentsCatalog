<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tents', function (Blueprint $table) {
            $table->bigIncrements('PK_Tent');
            $table->float('Price', 8, 2);
            $table->string('Name', 100);
            $table->integer('BerthsNumber');
            $table->string('MinimizedDimensions', 50);
            $table->string('MaximizedDimensions', 50);
            $table->integer('MinTemperature');
            $table->integer('MaxTemperature');
            $table->integer('Amount');
            $table->float('Weight', 8, 2);
            $table->string('ImgPath', 255);
            $table->text('Description');
            $table->text('ShortDescription');

            $table->unsignedBigInteger('PK_TentType');
            $table->unsignedBigInteger('PK_Manufacturer');

            $table->foreign('PK_TentType')->references('PK_TentType')->on('tent_types');
            $table->foreign('PK_Manufacturer')->references('PK_Manufacturer')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tents');
    }
}
