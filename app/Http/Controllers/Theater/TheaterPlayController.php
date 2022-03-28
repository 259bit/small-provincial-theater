<?php

namespace App\Http\Controllers\Theater;

use App\Http\Controllers\Base\ShowController;
use App\Http\Requests\Theater\TheaterPlayRequest;
use App\Models\Theater\TheaterPlay;
use App\Repositories\Theater\TheaterPlayRepository;

//Наследуемся от абстрактного для всех шоу: ShowController.
//Если в последствии в нашем маленьком театре будут устраивать концерты или выставки,
//можно будет задавать для них общее поведение.
class TheaterPlayController extends ShowController
{
    private mixed $theaterPlayRepository;

    public function __construct()
    {
        parent::__construct();
        $this->theaterPlayRepository = app(TheaterPlayRepository::class);
    }

    public function index()
    {
        return TheaterPlay::all();
    }

    public function store(TheaterPlayRequest $request)
    {
        //Для более прогнозируемого поведения приложения и удобного написания тестов,
        //все реквесты остаются на уровне контроллеров.
        //Если понадобится в дальнейшем, создаем DTO объект.
        $postValues = $request->input();

        //Чтобы контроллер не толстел, логику работы с моделями помещаем в репозиторий.
        return $this->theaterPlayRepository->create($postValues);
    }

    public function destroy($id): bool
    {
        $successDestroy = TheaterPlay::destroy($id);
        if ($successDestroy) {
            return true;
        }

        return false;
    }
}
