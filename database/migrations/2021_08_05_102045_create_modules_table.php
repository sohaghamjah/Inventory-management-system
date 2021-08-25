<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->enum('type', ['1','2']) -> comment = "1=devider, 2=module";
            $table->string('module_name') -> nullable();
            $table->string('divider_name') -> nullable();
            $table->string('icon_class') -> nullable();
            $table->string('url') -> nullable();
            $table->integer('order') -> nullable(); 
            $table->unsignedInteger('parent_id') -> nullable();
            $table->enum('target', ['_self', '_blank']) -> default('_self');
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
        Schema::dropIfExists('modules');
    }
}
