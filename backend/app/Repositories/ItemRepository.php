<?php

namespace App\Repositories;

use App\Models\Item;
use App\Traits\Filterable;
use Spatie\QueryBuilder\QueryBuilder;

class ItemRepository implements BaseRepositoryInterface
{
    use Filterable;

    private $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }

    public function fetch()
    {
        $results = request()->results ?? 20;
        $customAllowedFilters = [];
        $filters = $this->queryFilter($customAllowedFilters);

        return QueryBuilder::for($this->model::query())
            ->orderBy('id', 'desc')
            ->paginate($results);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function categoryTags()
    {
        $tags = Tag::where('tags.organization_id', $this->organizationId)
            ->select('tags.*', 'categories.name as category_name')
            ->join('categories', 'tags.category_id', '=', 'categories.id')
            ->get();

        return $tags->groupBy('category_name');
    }
}
