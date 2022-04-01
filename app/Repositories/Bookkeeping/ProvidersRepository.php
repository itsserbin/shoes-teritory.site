<?php

namespace App\Repositories\Bookkeeping;

use App\Models\Bookkeeping\Providers as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ProvidersRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке.
     *
     * @param int @id
     *
     * @return Model
     */
    public function getById($id)
    {
        return $this
            ->startConditions()
            ->find($id);
    }

    /**
     * Получить поставщиков для выбора на странице товара.
     *
     * @return mixed
     */
    public function getProvidersToProduct()
    {
        return $this
            ->startConditions()
            ->select('id', 'name')
            ->get();
    }

    /**
     * Вывести всех поставщиков в пагинации по 15 шт.
     *
     * @param null $perPage
     * @return mixed
     */
    public function getAllWithPaginate($perPage = 15)
    {
        return $this
            ->model::orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function create(array $data)
    {
        $model = new $this->model;
        $model->name = $data['name'];
        $model->catalog = $data['catalog'];
        $model->time_of_dispatch = $data['time_of_dispatch'];
        $model->availability = $data['availability'];
        $model->prepayment = $data['prepayment'];
        $model->prepayment_sum = $data['prepayment_sum'];
        $model->refunds = $data['refunds'];
        $model->refunds_sum = $data['refunds_sum'];
        $model->contacts = $data['contacts'];
        $model->comment = $data['comment'];

        return $model->save();
    }

    /**
     * @param int $id
     * @param array $request
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->name = $data['name'];
        $model->catalog = $data['catalog'];
        $model->time_of_dispatch = $data['time_of_dispatch'];
        $model->availability = $data['availability'];
        $model->prepayment = $data['prepayment'];
        $model->prepayment_sum = $data['prepayment_sum'];
        $model->refunds = $data['refunds'];
        $model->refunds_sum = $data['refunds_sum'];
        $model->contacts = $data['contacts'];
        $model->comment = $data['comment'];

        return $model->update();
    }

    /**
     * Удалить поставщика.
     *
     * @param int $id
     * @return int
     */
    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }

    public function list()
    {
        return $this->model->select('id', 'name')->orderBy('id', 'desc')->get();
    }
}
