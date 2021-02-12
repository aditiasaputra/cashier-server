<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Create a new Category Controller instance.
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
        $categories = Category::latest()->when($request->q, function ($categories) use ($request) {
            $categories = $categories->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(10);

        $status = 200;

        return response()->json(compact('categories'), $status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,256',
            'description' => "required|between:2,256",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $filename = null;

        if ($request->hasFile('photo')) {
            $filename = Str::random(6) . '-' . $request->name . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images/categories'), $filename);
        }

        $category = Category::create(array_merge(
            $validator->validated(),
            [
                'photo' => $filename,
            ]
        ));

        $message = 'Category succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            $status = 200;

            return response()->json(compact('category'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Category not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|between:2,256',
            'description' => "nullable|between:2,256",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $category = Category::findOrFail($id);

            $filename = $category->photo;

            if ($request->hasFile('photo')) {
                $filename = Str::random(6) . '-' . $category->name . '.jpg';
                $file = $request->file('photo');
                $file->move(base_path('public/images/categories'), $filename);

                unlink(base_path('public/images/categories/' . $category->photo));
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->photo = $filename;

            $category->save();

            $message = 'Category successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Category not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->photo) {
                unlink(base_path('public/images/categories/' . $category->photo));
            }

            $category->delete();

            $message = 'Category successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Category not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
