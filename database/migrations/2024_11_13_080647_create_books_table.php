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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('rental_price', 8, 2);
            $table->enum('availability_status', ['còn hàng', 'hết hàng'])->default('còn hàng');
            $table->year('publication_year');
            $table->string('publisher');
            $table->string('language');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('isbn')->unique();
            $table->string('image_url')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
