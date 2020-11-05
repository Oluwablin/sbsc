<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblProduct', function (Blueprint $table) {
            $table->increments('ProductRef');
            $table->integer('CategoryID')->nullable();
            $table->string('Product')->nullable();
            $table->integer('Quantity')->nullable();
            $table->float('Amount')->nullable();
            $table->date('EntryDate')->nullable();
            $table->date('ExpiryDate')->nullable();
            $table->string('ProductImage')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblProduct');
    }
}
