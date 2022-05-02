<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\User as Model;

/**
 * Class OrdersRepository
 * @package App\Repositories
 */
class UsersRepository extends CoreRepository
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
        return $this->model::where('id', $id)->with('roles')->first();
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
                'email'
            )->get();
    }

    public function getManagersList()
    {
        return $this
            ->model::select(
                'id',
                'name',
                'email'
            )
            ->wherehas('roles', function ($q) {
                $q->where('name', 'manager');
            })
            ->get();
    }

    public function create(array $data)
    {
        $model = new $this->model;
        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->password = bcrypt($data['password']);
        $model->save();
        $model->roles()->sync($data['role']);
        if ($data['role'] == 1) {
            $admin = Permission::where('slug', 'admin')->first();
            $model->permissions()->attach($admin);
        }
        return $model;
    }

    public function update(int $id, array $data)
    {
        $model = $this->getById($id);
        $model->name = $data['name'];
        $model->email = $data['email'];

        if (isset($data['password'])) {
            $model->password = bcrypt($data['password']);
        }

        $model->update();
        $model->roles()->sync($data['role']);
        return $model;
    }

    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

}
