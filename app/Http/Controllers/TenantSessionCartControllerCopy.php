<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantSessionCartControllerCopy extends Controller
{
    public function addProduct(Request $request)
    {
        $cart = session()->get('cart', []);

        $productId = $request->input('product_id');
        $roomName = $request->input('room_name');
        $quantity = $request->input('quantity', 1);
        $price = $request->input('price');

        if (isset($cart[$productId])) {
            // Increase quantity if product exists
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Add new product
            $cart[$productId] = [
                'room_name' => $roomName,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['message' => 'Product added to cart', 'cart' => $cart]);
    }
    public function getCart()
    {
        return response()->json(session()->get('cart', []));
    }
    public function removeProduct(Request $request)
    {
        $cart = session()->get('cart', []);

        $productId = $request->input('product_id');
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Product removed from cart', 'cart' => $cart]);
    }
    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('job_name');
        return response()->json(['message' => 'Cart cleared']);
    }
    public function createOrderPage()
    {
        $cart = session()->get('cart', []);
        $jobName = session()->get('job_name', ''); // Retrieve stored Job Name
        $roomNames = session()->get('room_names', []); // Retrieve stored Rooms

        return view('create_order', compact('cart', 'jobName', 'roomNames'));
    }
    public function saveJobName(Request $request)
    {
        session()->put('job_name', $request->input('job_name'));
        return response()->json(['message' => 'Job Name saved successfully']);
    }




}
