<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('reference_no');
            $table->date('date')->nullable();
            $table->string('sender')->nullable();
            $table->string('recipient')->nullable();
            $table->text('subject')->nullable();
            $table->text('remarks')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();

            $table->index(['reference_no', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registries');
    }
};
