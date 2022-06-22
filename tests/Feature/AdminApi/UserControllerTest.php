<?php

namespace Tests\Feature\AdminApi;

use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_user_is_user()
    {
        $response = $this->actingAsAdmin()->get('admin/api/user');

        $response->assertJsonFragment(['email' => 'admin@admin.com']);
    }
}
