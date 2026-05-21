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
        $productId = (int) $request->input('product_id');
        $roomId = (string) $request->input('room_id', '');
        $roomName = trim((string) $request->input('room_name'));
        $key = $roomId !== '' ? $roomId.'_'.$productId : (string) $productId;
        $price = (float) $request->input('price');
        $quantity = max(1, (int) $request->input('quantity', 1));
        $productData = Product::find($productId);

        if (! $productData) {
            return response()->json(['message' => 'Product not found'], 422);
        }

        $checkboxStatus = in_array($request->input('checkbox_status'), ['single', 'double'], true)
            ? $request->input('checkbox_status')
            : 'none';

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['checkbox_status'] = $checkboxStatus;
        } else {
            $cart[$key] = [
                'room_id' => $roomId,
                'room_name' => $roomName,
                'product_id' => $productId,
                'label' => $productData->label,
                'description' => $request->input('description'),
                'weight' => $request->input('weight'),
                'price' => $price,
                'quantity' => $quantity,
                'checkbox_status' => $checkboxStatus,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function removeProduct(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = (int) $request->input('product_id');
        $roomId = (string) $request->input('room_id', '');
        $key = $roomId !== '' ? $roomId.'_'.$productId : (string) $productId;

        if (isset($cart[$key])) {
            unset($cart[$key]);
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
