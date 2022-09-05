<?php

namespace App\Casts\Parsers;

use Macrame\Content\Contracts\Parser;

class MapParser implements Parser
{
    /**
     * Latitude.
     *
     * @var float
     */
    public float $lat;

    /**
     * Longitude.
     *
     * @var float
     */
    public float $lng;

    /**
     * Zoom.
     *
     * @var float
     */
    public float $zoom;

    /**
     * Create new Parser instance.
     *
     * @param  array $value
     * @return void
     */
    public function __construct(
        protected array $value
    ) {
        //
    }

    public function parse()
    {
        $lat = $this->value['lat'] ? (float) $this->value['lat'] : 54;
        $lng = $this->value['lng'] ? (float) $this->value['lng'] : 11;
        $zoom = $this->value['zoom'] ? (float) $this->value['zoom'] : 8;

        $this->lat = $lat;
        $this->lng = $lng;
        $this->zoom = $zoom;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge($this->value, [
            'lat'  => $this->lat,
            'lng'  => $this->lng,
            'zoom' => $this->zoom,
        ]);
    }
}
