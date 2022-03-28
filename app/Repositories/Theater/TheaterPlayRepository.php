<?php

namespace App\Repositories\Theater;

use App\Models\Theater\TheaterPlay;
use App\Repositories\Base\BaseRepository;
use Belamov\PostgresRange\Ranges\DateRange;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

class TheaterPlayRepository extends BaseRepository
{
    public function create(array $postValues): mixed
    {
        $theaterPlayDateRange = new DateRange(
            $postValues["theater_play_day_start"],
            $postValues["theater_play_day_end"],
            '[', ']'
        );

        $overlapsTheaterPlays = $this->getOverlapsTheaterPlays($theaterPlayDateRange);
        if ($overlapsTheaterPlays) {
            return $this->getOverlapsError($overlapsTheaterPlays);
        }

        return $this->startConditions()::firstOrCreate(
            [
                'theater_play_name' => $postValues['theater_play_name'],
                'theater_play_day_start' => $postValues["theater_play_day_start"],
                'theater_play_day_end' => $postValues["theater_play_day_end"],
                'theater_play_date_range' => $theaterPlayDateRange
            ]
        );
    }

    //Получаем выборку, где пересекаются диапазоны нового и существующих спектаклей.
    private function getOverlapsTheaterPlays(DateRange $dateRange): mixed
    {
        $columnsForSelection = [
            'id',
            'theater_play_name',
            'theater_play_day_start',
            'theater_play_day_end'
        ];

        $overlapsTheaterPlays = DB::table('theater_plays')
            ->select($columnsForSelection)

            //Используем макрос из пакета https://github.com/belamov/postgres-range/
            //Аналогичен постгрес оператору &&
            ->whereRangeOverlaps('theater_play_date_range', $dateRange)
            ->get();

        if ($overlapsTheaterPlays->isNotEmpty()) {
            return $overlapsTheaterPlays;
        }
        return false;
    }

    //TODO Вынести работу с ошибками в отдельную сущность
    private function getOverlapsError(Collection $overlapsTheaterPlays): Collection
    {
        $overlapsError = new stdClass();
        $overlapsError->error_text = 'Creating error. Chosen time is overlapped.';
        $overlapsError->theater_plays = $overlapsTheaterPlays;

        return collect($overlapsError);
    }

    protected function getModelClass(): string
    {
        return TheaterPlay::class;
    }
}
