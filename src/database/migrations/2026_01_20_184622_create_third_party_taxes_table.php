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
        Schema::create('third_party_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->string('integration_type')->nullable();
            $table->unsignedBigInteger('mapping_id')->nullable();
            $table->unsignedBigInteger('third_party_access_id');
            $table->unsignedBigInteger('sales_tax_group_id')->nullable();
            $table->unsignedBigInteger('purchase_tax_group_id')->nullable();
            $table->boolean('apply_on_sales')->default(false);
            $table->boolean('apply_on_purchases')->default(false);
            $table->unsignedBigInteger('mapping_sales_tax_rate_id')->nullable();
            $table->unsignedBigInteger('mapping_purchase_tax_rate_id')->nullable();
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();

            $table->foreign('third_party_access_id')->references('id')->on('third_party_accesses')->onDelete('cascade');
            $table->foreign('mapping_id')->references('id')->on('third_party_mappings')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_party_taxes');
    }
};
