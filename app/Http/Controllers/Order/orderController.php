<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class orderController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    
    public function order(Request $request)
    {
        $rules = [
            'quantity' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ];

        $this->validate($request, $rules);

        $order = $request->all();
        $order['user_id'] = auth()->user()->id;
        $order = Order::create($order);

        $product = Product::findOrfail($request->product_id);
        

        if($request->quantity > $product->Available_Stock){
            return $this->ApiResponse('Failed to order this product due to unavailability of the stock.', 400);
        }

        $product->Available_Stock = ($product->Available_Stock - $request->quantity);
        $product->save();
        return $this->ApiResponse('You have successfully ordered this product.', 201);
    }
}
