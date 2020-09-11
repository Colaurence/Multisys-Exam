<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEmailValidation()
    {
        $user = User::find(1);
        $formData = [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $headers = ['accept' => 'application/json'];

        $response = $this->post('/api/register', $formData, $headers);
        $response->assertStatus(400)
                 ->assertJson([
                    'message' => 'The given data was invalid.'
                    ,
                    'errors' => [
                        'email' => ['The email has already been taken.'],
                    ]
                ]);
    }
}
