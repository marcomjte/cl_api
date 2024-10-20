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
        Schema::create('person', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('note')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('url_web_age')->nullable();
            $table->string('work_company')->nullable();
            $table->timestamps();
        });

        Schema::create('phone', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->timestamps();
            $table->foreignId('person_id')
                ->constrained(table: 'person', indexName: 'phone_person_id_foreign_key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('email', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->timestamps();
            $table->foreignId('person_id')
                ->constrained(table: 'person', indexName: 'email_person_id_foreign_key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->timestamps();
            $table->foreignId('person_id')
                ->constrained(table: 'person', indexName: 'address_person_id_foreign_key')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person');
        Schema::dropIfExists('phone');
        Schema::dropIfExists('email');
        Schema::dropIfExists('address');
    }
};
