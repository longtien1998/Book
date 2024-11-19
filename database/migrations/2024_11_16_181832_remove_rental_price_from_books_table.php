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
        Schema::table('books', function (Blueprint $table) {
            // $table->dropColumn('rental_price'); // Xóa cột 'rental_price'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // $table->decimal('rental_price', 8, 2)->nullable(); // Hoàn tác: thêm lại cột 'rental_price'
        });
    }
};
