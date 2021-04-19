<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->foreignId('sequence_id')->constrained('sequences')->onDelete('cascade');
            $table->string('from_number',255)->nullable()->default('-1');
            $table->string('to_number',255)->nullable()->default('-1');
            $table->boolean('isSent')->nullable()->default(false);
            $table->string('direction',255)->nullable()->default('-1');
            $table->string('type',255)->nullable()->default('-1');
            $table->timestamp('send_date')->nullable()->useCurrent();
            $table->string('status',255)->nullable()->default('-1');
            $table->string('errorCode',255)->nullable()->default('-1');
            $table->longText('body')->nullable();
            $table->json('response')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
