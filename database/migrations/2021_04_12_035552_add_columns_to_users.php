<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username',255)->after('email')->unique();
            $table->string('name',255)->nullable();
            $table->string('uuid',255)->nullable();
            $table->timestamp('email_verified_at')->useCurrent();
            $table->string('device_id',255)->nullable();
            $table->longText('image')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->string('gender',255)->nullable();
            $table->string('status',255)->nullable();
            $table->integer('role_id')->default(1);
            $table->string('contact',255)->nullable();
            $table->string('online_status',255)->nullable()->default('Offline');
            $table->longText('street_address')->nullable();
            $table->longText('landmark')->nullable();
            $table->string('city',255)->nullable();
            $table->string('state',255)->nullable();
            $table->string('postal_code',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('current_location',255)->nullable();
            $table->string('city_geonameId',255)->nullable();
            $table->string('state_geonameId',255)->nullable();
            $table->string('country_geonameId',255)->nullable();
            $table->string('postalcode_geonameId',255)->nullable();
            $table->string('geocode',255)->nullable();
            $table->string('city_lat',255)->nullable();
            $table->string('city_ln',255)->nullable();
            $table->string('state_lat',255)->nullable();
            $table->string('state_ln',255)->nullable();
            $table->string('country_lat',255)->nullable();
            $table->string('country_ln',255)->nullable();
            $table->string('postal_code_lat',255)->nullable();
            $table->string('postal_code_ln',255)->nullable();
            $table->string('city_name',255)->nullable();
            $table->string('state_name',255)->nullable();
            $table->string('country_name',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
