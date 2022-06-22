<?php

namespace Tests\Feature\AdminApi;

use Admin\Http\Middleware\AuthenticateAdmin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    public function test_page_route_returns_a_list_of_all_pages()
    {
        // $routes = array_map(function (\Illuminate\Routing\Route $route)     {
        //     return $route->uri;    
        // }, (array) \Illuminate\Support\Facades\Route::getRoutes()->getIterator());
        // dump($routes);
    
        $response = $this->withoutMiddleware(AuthenticateAdmin::class)
                        ->get('/admin/api/pages');
        $response->assertOk();
    }

    public function test_page_tree_route_returns_the_page_tree(){
        $response = $this->withoutMiddleware(AuthenticateAdmin::class)
                        ->get('admin/api/pages/tree')->assertOk();
    }

    public function test_a_page_can_be_added(){

        $admin = \Tests\Models\User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true,
            'password' => 'password'
        ]);
        $payload = [
            'name' => 'Test',
            'slug' => 'test',
        ];

        $response = $this->actingAs($admin)
                    ->post('admin/api/pages/', $payload);

        $response->assertStatus(201);
    }
}
