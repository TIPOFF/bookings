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
            $table->foreignIdFor(app('user'));
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }
}
