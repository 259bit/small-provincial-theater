<?php

namespace Database\Factories\Theater;

use App\Models\Theater\TheaterPlay;
use Belamov\PostgresRange\Ranges\DateRange;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class TheaterPlayFactory extends Factory
{
    protected $model = TheaterPlay::class;

    public function definition(): array
    {
        $randomDate = $this->faker->date();

        $theaterPlayDayStart = new Carbon($randomDate);
        $theaterPlayDayEnd = (new Carbon($randomDate))->addDays(random_int(1, 8));
        $theaterPlayDateRange = new DateRange($theaterPlayDayStart, $theaterPlayDayEnd, '[', ']');

        $randomCreatedAt = (new Carbon($randomDate))->subMonths(random_int(1, 3));

        return [
            'theater_play_name' => $this->faker->name(),
            'theater_play_day_start' => $theaterPlayDayStart->format('d-m-Y'),
            'theater_play_day_end' => $theaterPlayDayEnd->format('d-m-Y'),
            'theater_play_date_range' => $theaterPlayDateRange,
            'created_at' => $randomCreatedAt,
            'updated_at' => $randomCreatedAt,
        ];
    }
}
