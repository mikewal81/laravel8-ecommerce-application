<?php
namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;
use App\Traits\UploadAble;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class CategoryRepository extends BaseRepository implements CategoryContract
{
    use UploadAble;

    public function __construct(Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array|string[] $columns
     * @return mixed
     */
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    public function createCategory(array $params)
    {
        try {
            $collection  = collect($params);
            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof UploadedFile))
            {
                $image = $this->uploadOne($params['image'], 'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu', 'image', 'featured'));

            $category = new Category($merge->all());

            $category->save();

            return $category;
        } catch (QueryException $exception){
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCategory(array $params)
    {
        $category = $this->findCategoryById($params['id']);
        $collection = collect($params)->except('_token');

        if ($collection->has('image') && ($params['image'] instanceof UploadedFile))
        {
            if ($category->image != null)
            {
                $this->deleteOne($category->image);
            }
            $image = $this->uploadOne($params['image'], 'categories');

            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu', 'image', 'featured'));
        } else {
            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu',  'featured'));
        }

        $category->update($merge->all());

        return $category;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCategory($id)
    {
        $category = $this->findCategoryById($id);

        $category->delete();

        return $category;
    }

    /**
     * @return Category|\Illuminate\Database\Eloquent\Builder|Builder|mixed
     */
    public function deletedCategories()
    {
        return Category::onlyTrashed()->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restoreCategory($id)
    {
        return Category::onlyTrashed()
                    ->where('id', $id)
                    ->restore();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function permanentDeleteCategory($id)
    {
        $category = Category::onlyTrashed()->find($id);

        if ($category->image != null)
        {
            $this->deleteOne($category->image);
        }

        $category->forceDelete();

        return $category;
    }
}
