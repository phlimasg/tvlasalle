<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->date('dt_inicio');
            $table->date('dt_fim');
            $table->string('video_url')->unique();
            $table->string('tipo');
            $table->integer('ativo');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_autorizacao')->nullable();
            $table->unsignedBigInteger('filial_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_autorizacao')->references('id')->on('users');
            $table->foreign('filial_id')->references('id')->on('filials');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');        
    }
}
