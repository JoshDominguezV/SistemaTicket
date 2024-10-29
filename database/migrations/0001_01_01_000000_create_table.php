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
        // Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Banks or Methods table
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Access table
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->string('access_level');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Branches table
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Delivery methods table
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->timestamps();
        });

        // Deliveries table
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('method_id')->constrained('delivery_methods')->onDelete('cascade');
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->timestamps();
        });

        // Tickets table
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('client_phone');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('delivery_id')->constrained('deliveries')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->text('comments')->nullable();
            $table->date('date');
            $table->string('receipt_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['open', 'closed']);
            $table->foreignId('assignment_id')->constrained('roles')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
        });

        // Chat table
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('access_id')->constrained('accesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('delivery_methods');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('accesses');
        Schema::dropIfExists('banks');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('table');
    }
};
