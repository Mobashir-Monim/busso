<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSAMLEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_a_m_l_entities', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('resource_group_id');
            $table->string('folder');
            $table->string('key');
            $table->string('cert');
            $table->text('doc')->nullable();
            $table->text('issuer')->nullable();
            $table->text('sig')->nullable();
            $table->text('acs')->nullable();
            $table->text('aud')->nullable();
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
        Schema::dropIfExists('s_a_m_l_entities');
    }
}
