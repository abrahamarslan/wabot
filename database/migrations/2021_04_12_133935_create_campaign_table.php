<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->json('flags')->nullable();
            $table->string('title',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('url_slug',255)->nullable();
            $table->longText('body')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->boolean('isCompleted')->nullable()->default(false);
            $table->timestamp('start_at')->nullable()->useCurrent();
            $table->integer('interval')->nullable()->default(0);
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
        Schema::dropIfExists('campaign');
    }
}
