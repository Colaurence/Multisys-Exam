<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuccessfulRegisterTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessfulRegister()
    {
        $formData = [
            'email' =>  $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/api/register', $formData);
        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'User successfully registered' 
                 ]);
    }
}
