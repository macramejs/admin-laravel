<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Tests\Models\User;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup a test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testbench'])->run();

        $this->admin = User::firstOrCreate([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => 'admin',
            'is_admin' => true,
        ]);
    }

    public function actingAsAdmin($admin = null)
    {
        return $this->actingAs($admin ?? $this->admin);
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [TestServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
