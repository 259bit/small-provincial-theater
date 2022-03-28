<?php

namespace App\Models\Theater;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class TheaterPlay extends Model
{
    use HasFactory;

    protected $fillable = [
        'theater_play_name',
        'theater_play_day_start',
        'theater_play_day_end',
        'theater_play_date_range'
    ];

    //С фронта приходят только даты, добавляем через мутаторы время начала спектакля из
    //константы, чтобы хранить в базе полные данные.

    public function theaterPlayDayStart(): Attribute
    {
        $theaterPlayTimeStart = Config::get('constants.THEATER_PLAY_TIME_START');
        return new Attribute(
            set: fn($date) => (new Carbon("$date $theaterPlayTimeStart")),
        );
    }

    public function theaterPlayDayEnd(): Attribute
    {
        $theaterPlayTimeStart = Config::get('constants.THEATER_PLAY_TIME_START');
        return new Attribute(
            set: fn($date) => (new Carbon("$date $theaterPlayTimeStart")),
        );
    }
}
