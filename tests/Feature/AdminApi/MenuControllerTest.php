<?php

namespace Tests\Feature\AdminApi;

use Tests\TestCase;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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