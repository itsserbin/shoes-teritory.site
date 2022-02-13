<?php

namespace App\Repositories;

use App\Models\Banner as Model;
use App\Models\Enum\MassActions;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CategoriesRepository
 * @package App\Repositories
 */
class BannersRepository extends CoreRepository
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
        return $this->startConditions()->find($id);
    }

    /**
     * @param string $sort
     * @param string $param
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15)
    {
        return $this
            ->model
            ->select(
                'id',
                'title',
                'sort',
                'image',
                'link',
                'published',
                'created_at',
                'updated_at',
            )
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function getForPublic()
    {
        $columns = [
            'id',
            'title',
            'image',
            'sort',
            'link'
        ];

        return $this
            ->model::select($columns)
            ->where('published', 1)
            ->orderBy('sort', 'desc')
            ->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $model = new $this->model;
        $model->title = $data['title'];
        $model->link = $data['link'];
        $model->image = $data['image'];
        $model->published = $data['published'];

        return $model->save();
    }

    /**
     * Обновление данных категории.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->title = $data['title'];
        $model->link = $data['link'];
        $model->image = $data['image'];
        $model->published = $data['published'];

        return $model->update();
    }

    /**
     * @param int $id
     * @return int
     */
    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }

    /**
     * @param int $id
     * @param $value
     * @return mixed
     */
    public function updateSort(int $id, $value)
    {
        return $this->model::where('id', $id)->update(['sort' => $value ?? null]);
    }

    /**
     * @param $action
     * @param $data
     * @return bool
     */
    public function massActions($action, $data): bool
    {
        if ($action == MassActions::NOT_PUBLISHED) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::NOT_PUBLISHED) {
                    $this->model->where('id', $item)->update(['published' => 0]);
                }
            }

            return true;
        } elseif ($action == MassActions::PUBLISHED) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::PUBLISHED) {
                    $this->model->where('id', $item)->update(['published' => 1]);
                }
            }
            return true;
        } elseif ($action == MassActions::DESTROY) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::DESTROY) {
                    $this->model::destroy($item);
                }
            }
            return true;
        }
        return false;
    }
}
