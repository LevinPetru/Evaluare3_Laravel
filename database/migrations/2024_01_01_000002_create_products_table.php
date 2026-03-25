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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            
            // O SINGURĂ DATĂ: Această linie creează coloana ȘI relația
            $table->foreignId('image_id')->nullable()->constrained('images')->onDelete('set null');
            
            $table->integer('quantity');
            $table->string('producer');
            $table->tinyInteger('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
