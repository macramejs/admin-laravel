<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Stringable;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class MenuLinkCast implements CastsAttributes, Stringable
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
        $parsed = parse_url($this->value);

        if (! $parsed || ($parsed['scheme'] ?? '') != 'route') {
            return $this->value;
        }

        $name = $parsed['host'] ?? '';
        parse_str($parsed['query'] ?? '', $parameters);

        try {
            return route($name, $parameters);
        } catch (RouteNotFoundException $e) {
            //
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value ?: '';
    }
}
