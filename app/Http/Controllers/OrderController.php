<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function getOrder()
    {
        $order = Order::with('products')->get();
        if ($order->isEmpty()) {
            return response()->json([
                'message' => 'Order List',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Order List',
            'data' => $order
        ], 200);
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ], [
            'products.required' => 'Products are required!',
            'products.array' => 'Products must be an array!',
            'products.*.id.required' => 'Product ID is required!',
            'products.*.id.exists' => 'Product ID must exist!',
            'products.*.quantity.required' => 'Quantity is required!',
            'products.*.quantity.integer' => 'Quantity must be an integer!',
            'products.*.quantity.min' => 'Quantity must be at least 1!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'data' => $validator->errors()
            ], 422);
        }

        $order = Order::create();

        foreach ($request->input('products') as $product) {
            $productModel = Product::find($product['id']);

            if (!$productModel) {
                return response()->json([
                    'message' => 'Product not found'
                ], 404);
            }

            if ($productModel->stock < $product['quantity']) {
                return response()->json([
                    'message' => 'Product out of stock'
                ], 400);
            }

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);

            $productModel->stock -= $product['quantity'];
            $productModel->sold += $product['quantity'];
            $productModel->save();
        }

        $orderWithDetails = Order::with('products')->find($order->id);

        return response()->json([
            'message' => 'Order created',
            'data' => $orderWithDetails
        ], 200);
    }

    public function detailOrder($id)
    {
        $order = Order::with('products')->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Order details',
            'data' => $order
        ], 200);
    }

    public function deleteOrder($id)
    {
        $order = Order::with('products')->findOrFail($id);
        $order->delete();

        if ($order) {
            return response()->json([
                'message' => 'Order deleted successfully!',
                'data'    => $order
            ], 200);
        } else {
            return response()->json([
                'message' => 'Order not found!',
            ], 404);
        }
    }

}
