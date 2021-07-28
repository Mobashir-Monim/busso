<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('log_type');
            $table->string('url');
            $table->string('route_name');
            $table->mediumText('change_data');
            $table->boolean('reverted')->default(false);
            $table->uuid('user_id');
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
        Schema::dropIfExists('change_logs');
    }
}
