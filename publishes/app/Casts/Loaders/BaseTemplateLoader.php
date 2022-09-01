<?php

namespace App\Casts\Loaders;

use Closure;
use App\Models\Page;
use App\Services\CacheService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Macrame\Content\Contracts\Loader;
use Illuminate\Contracts\Support\Jsonable;

abstract class BaseTemplateLoader implements Loader
{   
    /**
     * Create new BaseTemplateLoader instance.
     *
     * @param Page $page
     * @return void 
     */
    public function __construct(
        protected Page $page
    )
    {
        //
    }

    /**
     * Get remembered data.
     *
     * @param  string $key
     * @param  array $classes
     * @param  string $resource
     * @param  Closure $closure
     * @return mixed
     */
    protected function remember(string $key, array $classes, string $resource, Closure $closure)
    {
        return app(CacheService::class)->remember(
            $classes, $key, 
            function() use($closure, $resource){
                $data = $closure();

                return $data instanceof Collection
                    ? $this->collectionToArray($resource, $data)
                    : $this->instanceToArray($resource, $data);
            }
        );
    }

    /**
     * Get remembered data.
     *
     * @param  string $key
     * @param  array $classes
     * @param  string $resource
     * @param  string $index
     * @param  Closure $closure
     * @return mixed
     */
    protected function rememberIndex(string $key, array $classes, string $resource, string $index, Closure $query)
    {
        return app(CacheService::class)->remember(
            $classes, $key, 
            function() use($index, $query, $resource) {
                return json_decode((new $index)->items(
                    request(), $query(), $resource
                )->toJson());
            }
        );
    }

    /**
     * Get the array representation of the given collection.
     *
     * @param string $resource
     * @param Collection $collection
     * @return array
     */
    protected function collectionToArray(string $resource, Collection $collection): array
    {
        return json_decode($resource::collection($collection)->toJson());
    }

    /**
     * Get the array representation of the given instance.
     *
     * @param string $resource
     * @param Collection $collection
     * @return array
     */
    protected function instanceToArray(string $resource, $instance): array
    {
        return json_decode((new $resource($instance))->toJson());
    }
}
