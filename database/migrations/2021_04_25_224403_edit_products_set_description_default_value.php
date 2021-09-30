<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditProductsSetDescriptionDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {/*
        Schema::table('products', function (Blueprint $table) {
           $table->text('description')->default("note 1:")->change();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {/*
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->default(NULL)->change();
        });*/
    }
}
