<?php

namespace Tests\Unit;

use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $response = $this->get("/404");
        $response->assertStatus(404);
    }
    public function test_post()
    {
        $response = $this->get("/posts");
        $response->assertStatus(200);
        $response->assertSee("Sensive Blog");
        $response->assertViewHas("posts");
    }
}
