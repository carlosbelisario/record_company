<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordCompanyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->date('published');
        });

        Schema::create('artists', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', '100');
        });

        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('rol', '100');
        });

        Schema::create('album_artist', function(Blueprint $table) {
            $table->integer('album_id')->unsigned()->default(0);
            $table->integer('artist_id')->unsigned()->default(0);
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
        });

        Schema::create('artist_roles', function(Blueprint $table) {
            $table->integer('artist_id')->unsigned()->default(0);
            $table->integer('roles_id')->unsigned()->default(0);
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('album_artist');
        Schema::drop('artist_roles');
        Schema::drop('albums');
        Schema::drop('artists');
        Schema::drop('roles');
    }
}
