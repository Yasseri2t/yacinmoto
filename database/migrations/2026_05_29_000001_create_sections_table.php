<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('🔧');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed the 3 existing hardcoded sections
        DB::table('sections')->insert([
            ['name' => 'Pièces',             'slug' => 'pieces',   'icon' => '⚙️', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carénage',           'slug' => 'carenage', 'icon' => '🛡️', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Moteur & Électrique','slug' => 'moteur',   'icon' => '⚡', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
