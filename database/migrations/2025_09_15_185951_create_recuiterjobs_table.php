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
        Schema::create('recuiterjobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')
                ->nullable()->constrained('recuiters')->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->enum('status', ['draft', 'open', 'closed'])->default('open');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
