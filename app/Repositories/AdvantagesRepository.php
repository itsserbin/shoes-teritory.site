<?php

namespace App\Repositories;

use App\Models\Advantages as Model;

class AdvantagesRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model::where('id', $id)->first();
    }

    /**
     * @param string $sort
     * @param string $param
     * @param int $perPage
     * @return mixed
     */
    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15)
    {
        return $this
            ->model::select(
                'id',
                'icon',
                'text',
                'published',
            )
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        $model = new $this->model;
        $model->icon = $data['icon'];
        $model->text = $data['text'];
        $model->published = $data['published'];

        return $model->save();
    }

    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->icon = $data['icon'];
        $model->text = $data['text'];
        $model->published = $data['published'];

        return $model->update();
    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

    public function getAllToPublic()
    {
        return $this->model::where('published',1)->select('id', 'icon', 'text')->orderBy('id', 'desc')->get();
    }
}
