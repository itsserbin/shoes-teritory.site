<?php

namespace App\Repositories;

use App\Models\Role as Model;

/**
 * Class OrdersRepository
 * @package App\Repositories
 */
class RolesRepository extends CoreRepository
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
                'name',
                'email',
                'created_at',
                'updated_at',
            )
            ->with('roles')
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this
            ->model::select(
                'id',
                'name',
            )->get();
    }

}
