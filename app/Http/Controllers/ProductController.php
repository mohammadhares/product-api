<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page_num = $request->input('page_num', 1);
        $page_size = $request->input('page_size', 12);
        $order_by = $request->input('order_by', 'id');
        $order_direction = $request->input('order_direction', 'desc');
        $search_query = $request->input('search_query');

        $query = Product::query();
        if ($search_query) {
            $query->where('name', 'like', '%' . $search_query . '%')
                ->orWhere('description', 'like', '%' . $search_query . '%');
        }

        $query->orderBy($order_by, $order_direction);
        $result = $query->paginate($page_size, ['*'], 'page', $page_num);

        return response($result, 200);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response($product, 200);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->all();
        $file = $request->file('image');
        $filename = 'image' . date('Y-m-d_H-i-s') . '.' . $file->getClientOriginalExtension();
        $destination = "uploads/image";
        $path = $file->storeAs($destination, $filename, 'public');
        $data['image'] = $path;

        $product = Product::create($data);
        return response()->json([
            'message' => 'product created successfully',
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'image' . date('Y-m-d_H-i-s') . '.' . $file->getClientOriginalExtension();
            $destination = "uploads/image";
            $path = $file->storeAs($destination, $filename, 'public');
            $data['image'] = $path;
        }

        $product->update($data);
        return response()->json([
            'message' => 'product updated successfully',
            'product' => $product,
        ]);
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(['message' => 'product deleted successfully'], 200);
    }
}
