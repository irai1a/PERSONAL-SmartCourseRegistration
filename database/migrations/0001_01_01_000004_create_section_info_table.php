<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_info', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('section', 50);
            $table->integer('capacity'); // Use integer without size
            $table->string('lect_assigned', 50);
            $table->unsignedBigInteger('user_id')->nullable(); // Nullable user_id
            $table->unsignedBigInteger('course_id');
            $table->timestamps(); // Adds created_at and updated_at automatically

            // Foreign Keys (if applicable)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_info');
    }
}
