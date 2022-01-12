<?php

namespace App\Repositories\Products;

use App\Models\Enum\MassActions;
use App\Models\Products as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ProductRepository extends CoreRepository
{
    private $productsPhotoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productsPhotoRepository = app(ProductsPhotoRepository::class);
    }

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
    public function getById($id): Model
    {
        return $this->model->where('id', $id)->with('colors', 'categories', 'images')->first();
    }

    /**
     * Получить все товары.
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this
            ->model
            ->with('categories')
            ->where('published', 1)
            ->get();
    }

    /**
     * @param string $sort
     * @param string $param
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate(string $sort = 'id', string $param = 'desc', int $perPage = 15): LengthAwarePaginator
    {
        $columns = [
            'id',
            'status',
            'published',
            'description',
            'price',
            'discount_price',
            'preview',
            'h1',
            'sort',
            'vendor_code',
            'viewed',
            'total_sales',
            'created_at',
            'updated_at',
        ];

        return $this
            ->model
            ->select($columns)
            ->orderBy($sort, $param)
            ->paginate($perPage);
    }

    public function getProduct($id)
    {
        return $this->model::find($id);
    }

    public function getItemsWithPaginateOnProduction($perPage = null)
    {
        $columns = [
            'id',
            'price',
            'published',
            'discount_price',
            'preview',
            'sort',
            'h1',
        ];

        return $this
            ->startConditions()
            ->where('published', 1)
            ->select($columns)
            ->orderBy('sort', 'desc')
            ->paginate($perPage);
    }

    /**
     * Увеличить кол-во покупок товара на 1.
     *
     * @param $id
     * @return mixed
     */
    public function updateProductTotalSales($id)
    {
        $model = $this->model::where('id', $id)->select('total_sales')->first();

        return $this->model::where('id', $id)->update(['total_sales' => ++$model->total_sales]);
    }

    public function updateProductViewed($id)
    {
        $model = $this->model::where('id', $id)->select('viewed')->first();

        return $this->model::where('id', $id)->update(['viewed' => ++$model->viewed]);
    }

    public function getImages($id)
    {
        return $this->model::where('id', $id)->select('id', 'preview')->with('images')->first();
    }

    public function getReviews($id)
    {
        return $this->model::where('id', $id)->select('id')->with('Reviews')->first();
    }

    public function getRelativeProducts($id, $limit = 10)
    {
        $product = $this->model::where('id', $id)->with('categories')->first();

        return $this->model::where('id', '!=', $id)
            ->where('published', 1)
            ->select(
                'id',
                'h1',
                'price',
                'discount_price',
                'preview'
            )
            ->whereHas('categories', function ($q) use ($product) {
                $q->where('id', $product->categories[0]->id);
            })
            ->limit($limit)
            ->get();
    }


    public function search($search, $perPage = 15)
    {
        return $this->model::where('id', 'LIKE', "%$search%")
            ->orWhere('h1', 'LIKE', "%$search%")
            ->orWhere('content', 'LIKE', "%$search%")
            ->orWhere('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhere('vendor_code', 'LIKE', "%$search%")
            ->paginate($perPage);
    }

    public function updateSort(int $id, $value)
    {
        return $this->model::where('id', $id)->update(['sort' => $value ?? null]);
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

    public function attachColor($id, $data)
    {
        $model = $this->model::where('id', $id)->first();
        $model->colors()->attach($data['color_id']);
    }

    public function detachColor($id, $data)
    {
        $model = $this->model::where('id', $id)->first();
        $model->colors()->detach($data['color_id']);
    }

    public function getProductColors($id)
    {
        return $this->model->where('id', $id)->with('colors')->select('id')->first();
    }

    public function update(int $id, array $data)
    {
        $model = $this->model::where('id', $id)->first();

        $model->published = $data['published'];
        $model->status = $data['status'];

        $model->xs = $data['xs'];
        $model->s = $data['s'];
        $model->m = $data['m'];
        $model->l = $data['l'];
        $model->xl = $data['xl'];
        $model->xxl = $data['xxl'];
        $model->xxxl = $data['xxxl'];

        $model->h1 = $data['h1'];
        $model->title = $data['title'];
        $model->description = $data['description'];
        $model->content = $data['content'];
        $model->characteristics = $data['characteristics'];
        $model->size_table = $data['size_table'];

        $model->price = $data['price'];
        $model->discount_price = $data['discount_price'];
        $model->provider_id = $data['provider_id'];
        $model->trade_price = $data['trade_price'];
        $model->vendor_code = $data['vendor_code'];
        $model->preview = $data['preview'];
        $model->update();
        $model->categories()->sync($data['categories']);
        $this->productsPhotoRepository->create($model->id, $data['images']);
    }

    public function create($data)
    {
        $model = new $this->model;

        $model->published = $data['published'];
        $model->status = $data['status'];

        $model->xs = $data['xs'];
        $model->s = $data['s'];
        $model->m = $data['m'];
        $model->l = $data['l'];
        $model->xl = $data['xl'];
        $model->xxl = $data['xxl'];
        $model->xxxl = $data['xxxl'];

        $model->h1 = $data['h1'];
        $model->title = $data['title'];
        $model->description = $data['description'];
        $model->content = $data['content'];
        $model->characteristics = $data['characteristics'];
        $model->size_table = $data['size_table'];

        $model->price = $data['price'];
        $model->discount_price = $data['discount_price'];
        $model->provider_id = $data['provider_id'];
        $model->trade_price = $data['trade_price'];
        $model->vendor_code = $data['vendor_code'];
        $model->preview = $data['preview'];
        $model->save();

        if (count($data['colors'])) {
            foreach ($data['colors'] as $color) {
                $model->colors()->attach($color['id']);
            }
        }
        if (count($data['categories'])) {
            $model->categories()->sync($data['categories']);
        }
        $this->productsPhotoRepository->create($model->id, $data['images']);
    }

    public function destroy(int $id)
    {
        return $this->model::destroy($id);
    }

    public function getBestSellingProducts($perPage = 8)
    {
        $columns = [
            'id',
            'price',
            'published',
            'discount_price',
            'preview',
            'total_sales',
            'h1',
        ];

        return $this
            ->startConditions()
            ->where('published', 1)
            ->select($columns)
            ->orderBy('total_sales', 'desc')
            ->paginate($perPage);
    }
}
