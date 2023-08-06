<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint as MongoBlueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('article_metas', function (MongoBlueprint $table) {
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
        Schema::connection('mongodb')->dropIfExists('article_metas');
    }
};
