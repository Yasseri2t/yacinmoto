<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moto_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        DB::table('moto_types')->insert([
            ['name' => 'Cuxi 1', 'slug' => 'cuxi-1', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cuxi 2', 'slug' => 'cuxi-2', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fiddle 3', 'slug' => 'fiddle-3', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jett 4', 'slug' => 'jett-4', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void { Schema::dropIfExists('moto_types'); }
};
