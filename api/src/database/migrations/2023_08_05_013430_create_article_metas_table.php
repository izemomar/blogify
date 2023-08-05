<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_metas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('article_id');
            $table->string('key');
            $table->string('value');
            $table->enum('type', ['string', 'number', 'boolean', 'array', 'object', 'null'])->default('string');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_metas');
    }
};
