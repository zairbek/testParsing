<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rows', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('externalId')->unique();
            $table->string('name', 10);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rows');
    }
};
