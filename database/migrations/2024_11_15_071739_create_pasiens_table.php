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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id(); // id of the table
            $table->string('name'); // name of the table patient
            $table->string('phone'); // phone number of the table patient
            $table->text('address'); // address of the table patient
            $table->string('status'); // status of the table patient
            $table->date('in_date_at'); // date of the table patient
            $table->date('out_date_at')->nullable(); // date of the table patient
            $table->timestamps(); // timestamp of the table patient
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
