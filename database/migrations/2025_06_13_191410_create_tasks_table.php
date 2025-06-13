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
        Schema::create("tasks", function (Blueprint $table) {
            $table->id();
            $table->string("name", length: 255);
            $table->longText("description")->nullable();
            // zakladajac, ze priorytet i status sie nie zmienia
            $table->enum("priority", ["low", "medium", "high"])
                ->default("medium");
            $table->enum("status", ["to-do", "in progress", "done"])
                ->default("to-do");
            $table->date("due_date");
            // index - data nie moze byc w przeszlosci
            // $table->rawIndex(expression: "CHECK (due_date >= CURRENT_DATE)", name: "...");
            // $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tasks");
    }
};
