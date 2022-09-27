<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ItemTest extends TestCase
{
    /**
     *
     *
     * @return void
     */
    /** test */
    public function can_create_title()
    {
        $user = auth()->loginUsingId(368);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
