<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fail_sync_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('sync_integration_id');
            $table->string('object_id');
            $table->string('object_type');
            $table->text('message')->nullable();
            $table->string('type')->nullable();
            $table->string('merchant_id');
            $table->timestamps();
            $table->softDeletes();

//            $table->foreign('sync_integration_id')->references('id')->on('sync_integrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fail_sync_integrations');
    }
};
