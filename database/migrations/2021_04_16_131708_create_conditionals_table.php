<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conditionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->boolean('hasCondition')->nullable()->default(false);
            $table->integer('order')->nullable()->default(-1);
            $table->integer('if_sequence')->nullable()->default(-1);
            $table->string('is_sequence_option',255)->nullable();
            $table->integer('else_sequence')->nullable()->default(-1);

            $table->json('options')->nullable();
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
        Schema::dropIfExists('conditionals');
    }
}
