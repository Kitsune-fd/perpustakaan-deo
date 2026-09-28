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
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignUuid('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            $table->date('loaned_date');
            $table->date('due_date');
            $table->date('returned_date')->nullable();
            $table->timestamp('last_reminder_sent_at')->nullable();

            $table->string('status');
            $table->decimal('fine_amount', 8, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
