<?php
// database/migrations/xxxx_xx_xx_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Datos básicos
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            
            // Precios y stock
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable(); // Precio de referencia
            $table->decimal('cost_price', 10, 2)->nullable(); // Costo
            $table->integer('stock')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            
            // Categorización
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->json('tags')->nullable();
            
            // Estados
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_on_sale')->default(false);
            
            // Descuentos
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->timestamp('discount_start')->nullable();
            $table->timestamp('discount_end')->nullable();
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['status', 'is_active']);
            $table->index(['category', 'brand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};