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
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id');
            $table->bigInteger('phone_number');
            $table->text('photo')->nullable();
            $table->integer('module');
            $table->integer('type');
            $table->integer('status');
            $table->date('date');
            $table->string('title_uz', 255);
            $table->string('title_ru', 255);
            $table->string('title_en', 255)->nullable();
            $table->text('text_uz');
            $table->text('text_ru');
            $table->text('text_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
