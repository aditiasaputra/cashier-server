<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Create a new Product Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('jwt.verify');
        $this->middleware('token.verify');
        $this->middleware(['role:cashier'], ['only' => ['store', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $products = Product::latest()->when($request->q, function ($product) use ($request) {
            $product = $product->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);

        $status = 200;

        return response()->json(compact('products'), $status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,256',
            'category_id' => "required|integer",
            'weight' => "required|integer",
            'stock' => "required|integer",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $filename = null;

        if ($request->hasFile('photo')) {
            $filename = Str::random(6) . '-' . $request->name . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images/products'), $filename);
        }

        $product = Product::create(array_merge(
            $validator->validated(),
            [
                'photo' => $filename,
            ]
        ));

        $message = 'Product succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            $status = 200;

            return response()->json(compact('product'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Product not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|between:2,256',
            'category_id' => "nullable|integer",
            'weight' => "nullable|integer",
            'stock' => "nullable|integer",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $product = Product::findOrFail($id);

            $filename = $product->photo;

            if ($request->hasFile('photo')) {
                $filename = Str::random(6) . '-' . $product->name . '.jpg';
                $file = $request->file('photo');
                $file->move(base_path('public/images/products'), $filename);

                unlink(base_path('public/images/products/' . $product->photo));
            }

            $product->name = $request->name;
            $product->category_id = (int) $request->category_id;
            $product->weight = (int) $request->weight;
            $product->stock = (int) $request->stock;
            $product->photo = $filename;

            $product->save();

            $message = 'Product successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Product not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->photo) {
                unlink(base_path('public/images/products/' . $product->photo));
            }

            $product->delete();

            $message = 'Product successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Product not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
