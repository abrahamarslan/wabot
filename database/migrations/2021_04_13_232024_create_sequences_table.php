<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->longText('title')->nullable();
            $table->longText('body')->nullable();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->json('flags')->nullable();
            $table->boolean('hasOptions')->nullable()->default(false);
            $table->json('options')->nullable();
            $table->string('uuid',255)->nullable();
            $table->integer('order')->nullable()->default(-1);
            $table->boolean('status')->nullable()->default(true);
            $table->string('icon',255)->nullable();
            $table->string('thumbnail',255)->nullable();
            $table->string('image',255)->nullable();
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
        Schema::dropIfExists('sequences');
    }
}
