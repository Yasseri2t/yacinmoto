<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // FIX 4: Reviews are hidden by default until admin approves them
            // Prevents spam, fake reviews, and inappropriate content from appearing publicly
            $table->boolean('is_approved')->default(false)->after('comment');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }
};
