<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('callmeaf-user.model'),'author_id')->nullable()->constrained(getTableName(config('callmeaf-user.model')))->nullOnDelete();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('code');
            $table->string('discount_amount');
            $table->integer('max_uses')->nullable();
            $table->integer('max_uses_user')->nullable();
            $table->text('content')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
