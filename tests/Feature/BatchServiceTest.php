<?php

namespace Tests\Feature;

use use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BatchServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('api/simrequests');

        $response->assertStatus(200);
    }

    public function sortId(): string
    {
        // TODO: Implement sortId() method.
    }

    public function provides(): array
    {
        // TODO: Implement provides() method.
    }

    public function requires(): array
    {
        // TODO: Implement requires() method.
    }
}
