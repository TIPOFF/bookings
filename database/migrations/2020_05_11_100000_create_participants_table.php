<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('user'))->nullable()->index();
            $table->string('email')->unique();
            $table->string('name')->nullable(); // first name
            $table->string('name_last')->nullable();
            $table->date('dob')->nullable(); // date of birth
            $table->softDeletes(); // Soft delete if the participant email address bounces
            $table->timestamps();
        });
    }
}
