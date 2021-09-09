<?php

namespace App\Traits;

use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

trait FractalPaginated {

    protected function resolvePerPage ()
    {
        return request()->per_page ?? config('pagination.per_page');
    }

    /**
     *  Laravel query scope
     */
    public function scopePaginateAndTransform($query, $transformer, array $includes = [])
    {
        $collection = $query->paginate($this->resolvePerPage());
        return $collection->transformWith($transformer)
            ->parseIncludes($includes)
            ->paginateWith(new IlluminatePaginatorAdapter($collection));
    }
}
