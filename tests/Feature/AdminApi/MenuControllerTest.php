<?php

namespace Tests\Feature\AdminApi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        //
    }

    public function test_items()
    {
        $items = $this->get('/admin/api/menus');

        //dd($items->decodeResponseJson());
    }
}
