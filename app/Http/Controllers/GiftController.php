<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GiftController extends Controller
{
    /**
     * Create a new Gift Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('jwt.verify');
        $this->middleware(['role:cashier'], ['only' => ['show', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        // $gifts = Gift::latest()->when($request->q, function ($gifts) use ($request) {
        //     $gifts = $gifts->where('name', 'LIKE', '%' . $request->q . '%');
        // })->paginate(10);

        $gifts = Gift::all();

        $status = 200;

        return response()->json(compact('gifts'), $status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,256',
            'point' => 'required|integer',
            'stock' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $filename = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo')->store('gifts');
            $filename = $file;
        }

        $gift = Gift::create(array_merge(
            $validator->validated(),
            [
                'photo' => $filename,
            ]
        ));

        $message = 'Gift succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $gift = Gift::findOrFail($id);
            $status = 200;

            return response()->json(compact('gift'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|between:2,256',
            'point' => 'nullable|integer',
            'stock' => 'nullable|integer',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $gift = Gift::findOrFail($id);

            $filename = $gift->photo;

            $imageName = explode('/', $filename);
            $imageName = end($imageName);

            if (Storage::exists('gifts/' . $imageName)) {
                Storage::delete('gifts/' . $imageName);
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo')->store('gifts');

                $filename = $file;
            }

            $gift->name = $request->name;
            $gift->point = (int) $request->point;
            $gift->stock = (int) $request->stock;
            $gift->photo = $filename;

            $gift->save();

            $message = 'Gift successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $gift = Gift::findOrFail($id);

            $filename = $gift->photo;

            $imageName = explode('/', $filename);
            $imageName = end($imageName);

            if (Storage::exists('gifts/' . $imageName)) {
                Storage::delete('gifts/' . $imageName);
            }

            $gift->delete();

            $message = 'Gift successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
