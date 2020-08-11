<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); 
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('template')->nullable();
            $table->string('image')->nullable();
            $table->json('admin')->nullable();
            $table->json('settings')->nullable();
            $table->integer('parent')->default(0);
            $table->timestamps();
        });
        Schema::create('page', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); 
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('template')->nullable();
            $table->string('image')->nullable();
            $table->text('text')->nullable();
            $table->json('info')->nullable();
            $table->timestamps();
        });
        Schema::create('page_widjets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('page')->default(0);
            $table->string('widjet');
            $table->json('info')->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('section');
    }
}
