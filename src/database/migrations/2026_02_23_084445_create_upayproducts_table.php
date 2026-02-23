<?php
//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class extends Migration
//{
//    public function up(): void
//    {
//        Schema::create('upayproducts', function (Blueprint $table) {
//            $table->id();
//
//            $table->string('code')->nullable();
//            $table->string('name')->nullable();
//            $table->text('description')->nullable();
//
//            // sales
//            $table->decimal('sale_price', 15, 4)->nullable();
//            $table->string('sale_tax')->nullable();
//
//            // purchase
//            $table->decimal('cost_price', 15, 4)->nullable();
//            $table->string('purchase_tax')->nullable();
//
//            // inventory
//            $table->decimal('quantity', 15, 4)->nullable();
//            $table->boolean('is_inventory')->default(false);
//
//            // status
//            $table->boolean('active')->default(true);
//
//            $table->unsignedBigInteger('merchant_id');
//
//            $table->timestamps();
//        });
//    }
//
//    public function down(): void
//    {
//        Schema::dropIfExists('upayproducts');
//    }
//};
