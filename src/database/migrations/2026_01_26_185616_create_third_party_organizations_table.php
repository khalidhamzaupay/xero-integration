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
        Schema::create('third_party_organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('third_party_access_id');
            $table->string('third_party_id');
            $table->string('name')->nullable();
            $table->text('integration_type')->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('third_party_access_id')->references('id')->on('third_party_accesses')->onDelete('cascade');
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
