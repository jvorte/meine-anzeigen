// database/migrations/2025_07_29_093000_create_electronic_brands_table.php (adjust timestamp to be current)
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('electronic_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('electronic_brands'); }
};