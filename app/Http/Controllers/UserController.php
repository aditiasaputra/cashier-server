<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Create a new User Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('jwt.verify');
        $this->middleware(['role:cashier']);
    }

    public function index(Request $request)
    {
        // $users = User::latest()->when($request->q, function ($users) use ($request) {
        //     $users = $users->where('name', 'LIKE', '%' . $request->q . '%');
        // })->paginate($request->per_page);

        $users = User::select('users.*', 'roles.name as role')->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->get();

        $status = 200;

        return response()->json(compact('users'), $status);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,256',
            'email' => 'required|string|email|max:256|unique:users,email',
            'gender' => 'required|in:male,female',
            'place_of_birth' => 'nullable|string|between:2,256',
            'date_of_birth' => 'nullable|date_format:Y-m-d|before:today',
            'address' => "required|between:2,256",
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $filename = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo')->store('profiles');
            $filename = $file;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'photo' => $filename,
            'password' => $request->password,
        ]);

        $user->assignRole($request->role);

        $message = 'User succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $status = 200;

            return response()->json(compact('user'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'User not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|between:2,256',
            'email' => 'nullable|string|email|max:256',
            'gender' => 'nullable|in:male,female',
            'place_of_birth' => 'nullable|string|between:2,256',
            'date_of_birth' => 'nullable|date_format:Y-m-d|before:today',
            'address' => "nullable|between:2,256",
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'password' => 'nullable|string|confirmed|min:6',
            'role' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::findOrFail($id);

            $password = $request->password != '' ? $request->password : $user->password;

            $filename = $user->photo;

            $imageName = explode('/', $filename);
            $imageName = end($imageName);

            if (Storage::exists('profiles/' . $imageName)) {
                Storage::delete('profiles/' . $imageName);
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo')->store('profiles');

                $filename = $file;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->place_of_birth = $request->place_of_birth;
            $user->date_of_birth = $request->date_of_birth;
            $user->address = $request->address;
            $user->photo = $filename;
            $user->password = $password;

            $user->assignRole($request->role);

            $user->save();

            $message = 'User successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'User not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            $filename = $user->photo;

            $imageName = explode('/', $filename);
            $imageName = end($imageName);

            if (Storage::exists('profiles/' . $imageName)) {
                Storage::delete('profiles/' . $imageName);
            }

            $user->delete();

            $message = 'User successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'User not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
