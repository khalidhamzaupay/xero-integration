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
        Schema::create('sync_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamp('end_at')->nullable();
            $table->unsignedBigInteger('tenant_id');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_integrations');
    }
};
