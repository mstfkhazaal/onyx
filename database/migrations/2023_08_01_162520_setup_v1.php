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
        /**
         * * Tags Spatie
         */
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->string('type')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });
        /**
         * * Taggables Spatie
         */
        Schema::create('taggables', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->morphs('taggable');
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
        });
        /**
         * * Spatie Media Library
         */
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size');
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');
            $table->unsignedInteger('order_column')->nullable()->index();

            $table->nullableTimestamps();
        });
        /**
         * * Password reset tokens
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        /**
         * * Failed Jobs
         */
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
        /**
         * * Gender
         */
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * Nationality
         */
        Schema::create('nationalities', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * User Status
         */
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->json('name');
            $table->string('variant')->default('primary');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * Entity status
         */
        Schema::create('entity_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->json('name');
            $table->string('variant')->default('primary');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * Entity Type
         */
        Schema::create('entity_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->json('name');
            $table->string('variant')->default('primary');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * Entity
         */
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->foreignId('entity_type_id')
                ->constrained('entity_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('entity_status_id')
                ->constrained('entity_statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('contact_name')->nullable();
            $table->unsignedBigInteger('logo')->nullable()->index();
            $table->text('desc')->nullable();
            $table->string('website')->nullable();
            $table->text('comment')->nullable();
            $table->string('reg_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * User
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('entity_id')
                ->nullable()->constrained('entities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_status_id')
                ->default(2)
                ->constrained('user_statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->json('first_name');
            $table->json('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * * Entity User
         */
        Schema::create('entity_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('entity_id')->constrained('entities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * *  Entity Admin Added
         */
        Schema::table('entities', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->before('created_at')->index();
            $table->foreign('admin_id')->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('media');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('nationalities');
        Schema::dropIfExists('user_statuses');
        Schema::dropIfExists('entity_statuses');
        Schema::dropIfExists('entity_types');
        Schema::dropIfExists('entities');
        Schema::dropIfExists('entity_users');
        Schema::dropIfExists('users');

    }
};
