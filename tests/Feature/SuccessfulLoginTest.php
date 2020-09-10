<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestSuccessfulLogin extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $user = User::where('email', 'backend@multisyscorp.com')->first();
        if ($user === null) {
            $user = factory(User::class)->create([
                'email' => 'backend@multisyscorp.com',
                'password' => bcrypt('password'),
            ]);
        }
        $placeholder = ['email' => 'backend@multisyscorp.com',
                        'password' => 'password'];
        $response = $this->post('/api/login', $placeholder);

        $response->assertStatus(200)
                    ->assertJsonStructure([
                        'access_token',
                        'token_type',
                        'expires_in'
                    ]);
    }
}
