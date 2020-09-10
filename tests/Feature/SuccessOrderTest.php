<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuccessOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessOrder()
    {
        $user = User::find(1);
        $token = $token = auth()->attempt(['email' => $user->email, 'password' => 'password']);
        $headers = ['Authorization' => "Bearer $token"
                   ];
        
        $placeholder = [
            'product_id' => 2,
            'quantity' => 3,
        ];

        $response = $this->post('/api/orders', $placeholder, $headers);
        
        if($response->getStatusCode() == 400){
            $response->assertStatus(400)
                     ->assertJson([
                        'errors' => [
                            'message' => 'Failed to order this product due to unavailability of the stock.'
                        ]
                     ]);    
        }else{
            $response->assertStatus(201)
                     ->assertJson([
                         'message' => 'You have successfully ordered this product.' 
                     ]);    
        }
    }
}
