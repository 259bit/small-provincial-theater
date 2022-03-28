<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use function app;

//Репозиторий работы с работы с сущностью.
//Может выдавать наборы данных
//Не может создавать/изменять сущность
//Не может хранить состояний
abstract class BaseRepository
{

    protected Model $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass(): mixed;

    //При запросах создаем клон пустой модели, чтобы гарантированно не хранить состояние.
    protected function startConditions(): Model
    {
        return clone $this->model;
    }

}
