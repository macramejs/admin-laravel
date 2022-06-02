<?php

namespace App\Casts;

use App\Casts\Resolvers\LinkResolver;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Stringable;

class NavLink implements CastsAttributes, Stringable
{
    /**
     * Create new NavLink instance.
     *
     * @param  string $value
     * @return void
     */
    public function __construct(
        public $value = ''
    ) {
        //
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string                              $key
     * @param  mixed                               $value
     * @param  array                               $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new static($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string                              $key
     * @param  mixed                               $value
     * @param  array                               $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof $this) {
            return $value->value;
        }

        return $value;
    }

    /**
     * Get the url representation of the link.
     *
     * @return string
     */
    public function url()
    {
        return LinkResolver::urlFromLink($this->value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
