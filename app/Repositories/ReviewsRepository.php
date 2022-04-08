<?php

namespace App\Repositories;

use App\Models\Enum\MassActions;
use App\Models\Reviews as Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class OrdersRepository
 * @package App\Repositories
 */
class ReviewsRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function list($limit = 10)
    {
        return $this->model->where('status', 1)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }

    public function getById($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15)
    {
        return $this
            ->model
            ->select(
                'id',
                'name',
                'comment',
                'product_id',
                'created_at',
                'status'
            )
            ->with('products')
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update([
            'name' => $data['name'],
            'comment' => $data['comment'],
            'status' => $data['status']
        ]);
    }

    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }

    public function search($search, $perPage = 15)
    {
        return $this->model::where('id', 'LIKE', "%$search%")
            ->orWhere('name', 'LIKE', "%$search%")
            ->orWhere('comment', 'LIKE', "%$search%")
            ->orWhere('product_id', 'LIKE', "%$search%")
            ->with('products')
            ->paginate($perPage);
    }

    public function massActions($action, $data): bool
    {
        if ($action == MassActions::NOT_PUBLISHED) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::NOT_PUBLISHED) {
                    $this->model->where('id', $item)->update(['status' => 0]);
                }
            }

            return true;
        } elseif ($action == MassActions::PUBLISHED) {
            foreach ($data as $key => $item) {
                if ($key !== MassActions::PUBLISHED) {
                    $this->model->where('id', $item)->update(['status' => 1]);
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

    public function accept($id)
    {
        return $this->model::where('id', $id)->update(['status' => 1]);
    }

    public function getProductReviews($id)
    {
        return $this->model::whereHas('products', function ($q) use ($id) {
            $q->where('id', $id);
        })->where('status', 1)->select('id', 'name', 'comment')->get();
    }
}
