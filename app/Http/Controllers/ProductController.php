<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getProduct()
    {
        $product = Product::all();

        if ($product->isEmpty()) {
            return response()->json([
                'message' => 'Product List',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Product List',
            'data' => $product
        ], 200);
    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'sold' => 'required'
        ],
            [
                'name.required' => 'Name is required!',
                'price.required' => 'Price is required!',
                'stock.required' => 'Stock is required!',
                'sold.required' => 'Sold is required!',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation Failed',
                'data'    => $validator->errors()
            ],422);
        }
        else{
            $product = Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'sold' => $request->input('sold')
            ]);
            if ($product) {
                return response()->json([
                    'message' => 'Product created successfully!',
                    'data' => $product
                ], 200);
            }
        }
    }

    public function detailProduct($id)
    {
        $product = Product::whereId($id)->first();
        if ($product) {
            return response()->json([
                'message' => 'Product detail!',
                'data'    => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!',
            ], 404);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'sold' => 'nullable|integer',
        ], [
            'name.string' => 'Name must be a string!',
            'price.numeric' => 'Price must be a number!',
            'stock.integer' => 'Stock must be an integer!',
            'sold.integer' => 'Sold must be an integer!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'data' => $validator->errors()
            ], 422);
        }

        $product = Product::find($id);

        if ($product) {
            // Jika stok diberikan, tambahkan ke stok yang sudah ada
            if ($request->has('stock')) {
                $product->stock += $request->input('stock');
            }

            // Update atribut lain yang diberikan
            $product->update(array_filter($request->only(['name', 'price', 'sold'])));

            // Simpan perubahan
            $product->save();

            return response()->json([
                'message' => 'Product updated successfully!',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!',
            ], 404);
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        if ($product) {
            return response()->json([
                'message' => 'Product deleted successfully!',
                'data'    => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found!',
            ], 404);
        }
    }
}
