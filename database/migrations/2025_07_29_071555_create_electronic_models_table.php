// database/migrations/2025_07_29_093500_create_electronic_models_table.php (adjust timestamp)
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('electronic_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('electronic_brands')->onDelete('set null');
            $table->string('name');
            $table->timestamps();
            $table->unique(['brand_id', 'name']);
        });
    }
    public function down(): void { Schema::dropIfExists('electronic_models'); }
};