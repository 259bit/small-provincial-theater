<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTheaterPlaysTable extends Migration
{
    public function up(): void
    {
        Schema::create('theater_plays', static function (Blueprint $table) {
            $table->id();
            $table->string('theater_play_name');
            $table->dateTime('theater_play_day_start');
            $table->dateTime('theater_play_day_end');
            $table->dateRange('theater_play_date_range');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theater_plays');
    }
}
