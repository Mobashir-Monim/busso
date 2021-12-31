<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrustlessAuthValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('trustless_auth_values', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->uuid('requester_id');
        //     $table->string('type');
        //     $table->json('seasoning')->nullable();
        //     $table->json('values');
        //     $table->boolean('consumed');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trustless_auth_values');
    }
}
