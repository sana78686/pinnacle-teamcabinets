<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\CartProduct;
use App\Models\CartJob;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantCartController extends Controller
{

    public function addRoom(Request $request)
    {
        $user = Auth::user();
        $jobAvailableInCart = CartJob::where('user_id', $user->id)->where('job_name', $request->job_name)->first();
        if(empty($jobAvailableInCart))
        {
            CartJob::create([
                'user_id' => $user->id,
                'job_name' => $request->job_name
            ]);
        }
    }

    public function removeRoom(Request $request)
    {

        $user = Auth::user();
        $cartProducts = CartProduct::where('user_id', $user->id)->where('room_name', $request->room_name)->get();
        foreach($$cartProducts  as $product)
        {
            $product->delete();
        }

    }

    public function addProduct(Request $request)
    {

        $user = Auth::user();
        $product = Product::where('id', $request->product_id)->first();
        $cart_job = CartJob::where('user_id', $user->id)->first();
        $productAvailableInProduct = CartProduct::where('cart_job_id', $cart_job->id)
                                                ->where('room_name', $request->room_name)
                                                ->where('product_id', $request->product_id)
                                                ->where('created_at', Carbon::now())
                                                ->first();
        // dd($request->all());
        if(!empty($productAvailableInProduct))
        {
            $quantity = $productAvailableInProduct->quantity + 1;
            $productAvailableInProduct->quantity= $quantity;
            $productAvailableInProduct->save();
        }
        else
        {

            CartProduct::create([
                'cart_job_id' => $cart_job->id,
                'room_name' => $request->room_name,
                'product_id' => $request->product_id,
                // 'product_sku' => $request->product_sku,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);
        }
    }

    public function removeProduct(Request $request)
    {
        CartProduct::where('product_sku', $request->product_sku)->delete();
    }
}
