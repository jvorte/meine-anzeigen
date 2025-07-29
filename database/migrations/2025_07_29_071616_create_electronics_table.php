// database/migrations/2025_07_29_094000_create_electronics_table.php (adjust timestamp)
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('electronics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('electronic_brands')->onDelete('set null'); // IMPORTANT: electronic_brands
            $table->foreignId('electronic_model_id')->nullable()->constrained('electronic_models')->onDelete('set null');
            $table->string('condition');
            $table->integer('year_of_purchase')->nullable();
            $table->string('warranty_status')->nullable();
            $table->text('accessories')->nullable();
            $table->string('status')->default('active');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // Add the new specific fields for electronics
            $table->string('color')->nullable();
            $table->string('usage_time')->nullable();
            $table->string('power')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('storage_capacity')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('electronics'); }
};