<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestFailedLogin extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFailedLogin()
    {
        $placeholder = ['email' => 'backend@multisyscorp.com', 
                        'password' => 'invalidPass'];

        $response = $this->post('/api/login', $placeholder);
        $response->assertStatus(401)
            ->assertJson([
            'error' => 'Invalid Credentials',
            ]);
    }

    
}
