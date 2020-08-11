<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserentitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userentities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entities'); // к какой сущности относится поле
            $table->integer('cat')->default(0); // категория
            $table->string('name'); // Название поля
            $table->string('title')->nullable(); // краткий заголовок
            $table->string('type')->default('input[text]'); // тип поля
            $table->integer('main')->default(0); // Использовать поле как заголовок страницы
            $table->text('default')->nullable(); // значения по умолчанию
            $table->string('error')->nullable(); // сообщение об ошибке
            $table->integer('required')->default(0); 
            $table->integer('position')->default(0); // позиция
            $table->timestamps(); 
        });
        Schema::create('userentities_cat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entities'); // к какой сущности относится поле
            $table->string('name'); // Название категории
            $table->integer('position')->default(0); // позиция
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
        Schema::dropIfExists('userentities');
        Schema::dropIfExists('userentities_cat'); 
    }
}
