<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientOrderTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_client_can_make_orders(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
