<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
            $table->json('flags')->nullable();
            $table->string('name',255)->nullable();
            $table->string('uuid',255)->nullable();
            $table->string('country_code',255)->nullable();
            $table->string('contact',255)->nullable();
            $table->string('age',255)->nullable();
            $table->longText('address')->nullable();
            $table->string('pin',255)->nullable();
            $table->string('city_name',255)->nullable();
            $table->string('state_name',255)->nullable();
            $table->string('country_name',255)->nullable();
            $table->string('current_location',255)->nullable();
            $table->string('current_ctc',255)->nullable();
            $table->string('expected_ctc',255)->nullable();
            $table->string('on_notice',255)->nullable();

            $table->string('file',255)->nullable();
            $table->json('responses')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamp('registered_at')->nullable()->useCurrent();
            $table->boolean('approved')->nullable()->default(false);

            $table->json('conversations')->nullable()->comment('All bot conversations');

            $table->string('icon',255)->nullable();
            $table->string('thumbnail',255)->nullable();
            $table->string('image',255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
