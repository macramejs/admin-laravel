<?php

namespace Admin\Http\Indexes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Macrame\Index\Index;

class MediaIndex extends Index
{
    protected $defaultPerPage = 50;

    protected $mimeTypes = [
        'images'    => ['image/%'],
        'documents' => ['application/%'],
    ];

    /**
     * Handle search.
     *
     * @param  Builder $query
     * @param  string  $search
     * @return void
     */
    public function search(Builder $query, $search)
    {
        $query->where(function (Builder $query) use ($search) {
            $query
                ->where('filename', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Apply filter to the query.
     *
     * @param  Builder    $query
     * @param  Collection $filters
     * @return void
     */
    public function filter(Builder $query, Collection $filters)
    {
        if ($filters->has('collection')) {
            $this->filterCollection($query, $filters['collection']);
        }

        if ($filters->has('types')) {
            $this->filterTypes($query, $filters['types']);
        }
    }

    protected function filterTypes(Builder $query, $types)
    {
        if (! is_array($types)) {
            return;
        }

        $query->where(function ($subQuery) use ($types) {
            foreach ($types as $type) {
                if (! array_key_exists($type, $this->mimeTypes)) {
                    continue;
                }

                foreach ($this->mimeTypes[$type] as $mimeType) {
                    $subQuery->orWhere('mimetype', 'like', $mimeType);
                }
            }
        });
    }

    protected function filterCollection(Builder $query, $collection)
    {
        $query->whereHas('collections', fn ($q) => $q->where('key', $collection));
    }

    /**
     * Apply orders to the query.
     *
     * @param  Builder    $query
     * @param  Collection $sort
     * @return void
     */
    public function sort(Builder $query, Collection $sort)
    {
        foreach ($sort as $key => $direction) {
            $query->orderBy($key, $direction);
        }
    }
}
