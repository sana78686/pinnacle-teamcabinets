<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TenantSessionCartController extends Controller
{
        public function saveJobName(Request $request)
    {
        session()->put('job_name', $request->input('job_name'));
        return response()->json(['message' => 'Job Name saved successfully']);
    }

    public function addRoom(Request $request)
    {
        $rooms = session()->get('rooms', []);
        $roomName = trim($request->input('room_name'));

        if (!empty($roomName)) {
            $rooms[] = $roomName;
            session()->put('rooms', $rooms);
        }

        return response()->json(['message' => 'Room added successfully']);
    }

    public function removeRoom(Request $request)
    {
        $rooms = session()->get('rooms', []);
        $roomName = trim($request->input('room_name'));

        if (($key = array_search($roomName, $rooms)) !== false) {
            unset($rooms[$key]);
            session()->put('rooms', array_values($rooms));
        }

        return response()->json(['message' => 'Room removed successfully']);
    }

    public function addProduct(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $roomName = trim($request->input('room_name'));
        $price = floatval($request->input('price'));
        $quantity = 1;
        $product_data = Product::find($productId);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'room_name' => $roomName,
                'product_id' => $productId,
                'label' => $product_data->label,
                'description' => $request->input('description'),
                'weight' => $request->input('weight'),
                'price' => $price,
                'quantity' => $quantity,
                'double_check' => false, // Default double-check to false
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function removeProduct(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Product removed successfully']);
    }

    public function saveTotals(Request $request)
    {
        session()->put('total_price', $request->input('total_price'));
        session()->put('total_weight', $request->input('total_weight'));
        return response()->json(['message' => 'Totals saved successfully']);
    }

    public function clearCart()
    {
        session()->forget(['job_name', 'rooms', 'cart', 'total_price', 'total_weight']);
        return response()->json(['message' => 'Cart cleared successfully']);
    }

    public function getCart()
    {
        return response()->json([
            'job_name' => session()->get('job_name', ''),
            'rooms' => session()->get('rooms', []),
            'cart' => session()->get('cart', []),
            'total_price' => session()->get('total_price', '0.00'),
            'total_weight' => session()->get('total_weight', '0 lbs')
        ]);
    }




}
