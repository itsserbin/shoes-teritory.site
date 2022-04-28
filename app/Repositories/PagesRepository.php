<?php

namespace App\Repositories;

use App\Models\Enum\MassActions;
use App\Models\Page as Model;

class PagesRepository extends CoreRepository
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
                'heading',
                'h1',
                'published',
            )
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        $model = new $this->model;
        $model->slug = $data['slug'];
        $model->published = $data['published'];
        $model->heading = $data['heading'];
        $model->h1 = $data['h1'];
        $model->content = $data['content'];
        $model->meta_title = $data['meta_title'];
        $model->meta_description = $data['meta_description'];

        return $model->save();
    }

    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->slug = $data['slug'];
        $model->published = $data['published'];
        $model->heading = $data['heading'];
        $model->h1 = $data['h1'];
        $model->content = $data['content'];
        $model->meta_title = $data['meta_title'];
        $model->meta_description = $data['meta_description'];

        return $model->update();
    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

    public function getBySlug($slug)
    {
        return $this->model::where([
            ['published', 1],
            ['slug', $slug]
        ])->select(
            'slug',
            'heading',
            'h1',
            'meta_title',
            'meta_description',
            'content',
        )->first();
    }

    public function getPagesListToPublic()
    {
        return $this->model::where('published', 1)
            ->select(
                'id',
                'slug',
                'heading',
            )->get();
    }

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
