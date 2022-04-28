<?php

namespace App\Repositories;

use App\Models\Translations as Model;

class TranslationRepository extends CoreRepository
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
                'slug',
                'ua',
                'ru',
            )
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    public function search($search, $perPage = 15)
    {
        return $this->model::where('slug', 'LIKE', "%$search%")
            ->orWhere('ua', 'LIKE', "%$search%")
            ->orWhere('ru', 'LIKE', "%$search%")
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        $model = new $this->model;
        $model->slug = $data['slug'];
        $model->ua = $data['ua'];
        $model->ru = $data['ru'];

        return $model->save();
    }

    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->slug = $data['slug'];
        $model->ua = $data['ua'];
        $model->ru = $data['ru'];

        return $model->update();
    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

    public function getBySlug($slug)
    {
        return $this->model::where('slug', $slug)->first();
    }
}
