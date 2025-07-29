// database/migrations/2025_07_29_094500_create_electronic_images_table.php (adjust timestamp)
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('electronic_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electronic_id')->constrained('electronics')->onDelete('cascade');
            $table->string('image_path');
            $table->string('filename')->nullable();
            $table->boolean('is_thumbnail')->default(false);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('electronic_images'); }
};