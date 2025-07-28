<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Create 'brands' table
        // This table will store unique brand names (e.g., Apple, Samsung)
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 2. Create 'electronic_models' table
        // This table will store models associated with specific brands (e.g., iPhone 15 for Apple)
        Schema::create('electronic_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();

            // Ensure a brand doesn't have duplicate model names
            $table->unique(['brand_id', 'name']);
        });

        // 3. Create 'electronics' table (main ad table)
        Schema::create('electronics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Assuming ads belong to users

            // General ad details
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2); // 10 total digits, 2 after decimal for currency

            // Specific electronic details from your form
            $table->string('category')->nullable(); // From the 'Kategorie' dropdown in your form
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // Linked to the brands table
            $table->foreignId('electronic_model_id')->nullable()->constrained('electronic_models')->onDelete('set null'); // Linked to electronic_models
            // Note: The form has text inputs for 'brand' and 'model' alongside the IDs.
            // If these are meant for non-listed brands/models, consider adding:
            // $table->string('custom_brand_name')->nullable();
            // $table->string('custom_model_name')->nullable();
            // For now, I'm assuming the brand_id/electronic_model_id are preferred.

            $table->string('condition'); // 'neu', 'gebraucht', 'defekt'
            $table->integer('year_of_purchase')->nullable(); // 'Kaufjahr'
            $table->string('warranty_status')->nullable(); // 'Garantie-Status'
            $table->text('accessories')->nullable(); // 'Zubehör'

            // Common ad fields
            $table->string('status')->default('active'); // e.g., 'active', 'pending', 'sold', 'expired'
            $table->timestamp('published_at')->nullable(); // When the ad officially goes live

            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // For soft deleting ads
        });

        // 4. Create 'images' table (for ad photos)
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electronic_id')->constrained('electronics')->onDelete('cascade'); // Link to the electronic ad
            $table->string('path'); // Path to the image file
            $table->string('filename')->nullable(); // Original filename (optional)
            $table->boolean('is_primary')->default(false); // To mark one image as primary/thumbnail
            $table->integer('order')->nullable(); // For custom image order (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('electronics');
        Schema::dropIfExists('electronic_models');
        Schema::dropIfExists('brands');
    }
};