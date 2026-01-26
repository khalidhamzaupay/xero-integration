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
        Schema::create('third_party_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('access_key')->nullable();
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('refresh_token_expires_at')->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('assets_account_id')->nullable();
            $table->unsignedBigInteger('sale_account_id')->nullable();
            $table->unsignedBigInteger('purchase_account_id')->nullable();
            $table->unsignedBigInteger('default_purchase_payment_account_id')->nullable();
            $table->unsignedBigInteger('expense_account_id')->nullable();
            $table->unsignedBigInteger('default_expense_payment_account_id')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_party_accesses');
    }
};
