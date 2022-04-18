<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tasks extends Migration{

    public function up(){
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('elapsed_time');
            $table->boolean('running');
            $table->bigInteger('start_time');
            $table->boolean('deleted');

            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('tasks');
    }
}
