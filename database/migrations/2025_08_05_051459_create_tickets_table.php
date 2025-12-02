<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('NEW');
            $table->string('image')->default(null);
            $table->foreignId('assignee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->string('reporter_email', 255)->unique();
            $table->string('assignee_email', 255)->unique();
            $table->string('category');
            $table->string('classification');
            $table->string('service_type');
            $table->dateTime('date_reported')->default(FacadesDB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_closed')->nullable()->default(null);
            $table->string('severity')->default('NORMAL');
            $table->string('reporter_department');
            $table->text('resolution')->nullable()->default(null);
            $table->string('assignee_team')->nullable()->default(null);
            $table->string('performance');
            $table->decimal('sla', 8, 2);
            $table->decimal('tat', 8, 2);
            $table->decimal('total_tat', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
