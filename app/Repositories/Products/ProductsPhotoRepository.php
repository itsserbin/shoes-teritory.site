<?php

namespace App\Repositories\Products;

use App\Models\Enum\MassActions;
use App\Models\ProductsPhoto as Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ProductsPhotoRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function create($id, $data)
    {
        foreach ($data as $item) {
            $duplicate = $this->model::where([
                ['image', '=', $item['image']],
                ['product_id', '=', $id],
            ])->first();

            if (!$duplicate) {
                $model = new $this->model;
                $model->image = $item['image'];
                $model->product_id = $id;
                $model->save();
            }
        }
    }

    public function destroyImage($id)
    {
        return $this->model::destroy($id);
    }
}
