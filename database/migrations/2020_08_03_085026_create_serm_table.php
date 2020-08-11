<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSermTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serm_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('serm_id')->default(0);
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->integer('user')->default(0);
            $table->json('info')->nullable();
            $table->timestamps(); 
        });
        Schema::create('serm_search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('serach_id')->default(0);
            $table->string('serach_name')->nullable();
            $table->integer('region_id')->default(0);
            $table->string('type')->nullable();
            //$table->timestamps();
        });
        Schema::create('serm_search_yandex_region', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('region_id')->default(0);
            $table->string('name')->nullable(); 
            //$table->timestamps();
        });
        Schema::create('serm_keyword', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id')->default(0);
            $table->integer('serm_key_id')->default(0);
            $table->string('text')->nullable(0);
            $table->string('url')->nullable(0);
            $table->timestamps();
        });
        Schema::create('serm_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id')->default(0);
            $table->integer('serm_task_id')->default(0);
            $table->string('text')->nullable(0);
            $table->integer('search_id')->default(0);
            $table->integer('region_id')->default(0);
            $table->integer('status')->default(0); 
            $table->timestamps();
        });
        // Schema::create('serm_top', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->integer('project_id')->default(0);
            // $table->integer('serm_task_id')->default(0);
            // $table->string('text')->nullable(0);
            // $table->integer('search_id')->default(0);
            // $table->integer('region_id')->default(0);
            // $table->integer('status')->default(0); 
            // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serm_project');
        Schema::dropIfExists('serm_search');
        Schema::dropIfExists('serm_keyword');
        Schema::dropIfExists('serm_task');
    }
}
