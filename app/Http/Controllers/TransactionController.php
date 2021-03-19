<?php

namespace App\Http\Controllers;

use App\Models\Prefix;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{User, Product, Transaction};
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionController extends Controller
{
    /**
     * Create a new Transaction Controller instance.
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
        $users = User::select('users.*', 'roles.name as role')->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->join('roles', 'model_has_roles.role_id', '=', 'roles.id')->where('roles.name', 'customer')->get();
        $products = Product::select('products.*', 'categories.name as category')->join('categories', 'products.category_id', '=', 'categories.id')->get();
        $transactions = Transaction::select('transactions.*', 'products.name as product', 'users.name as customer_name')->join('products', 'transactions.product_id', '=', 'products.id')->join('users', 'transactions.user_id', '=', 'users.id')->get();

        $status = 200;

        return response()->json(compact('users', 'products', 'transactions'), $status);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'product_id' => "required|integer",
            'user_id' => "required|integer",
            'cashier_name' => "required|string",
            'quantity' => "required|integer",
            'price' => "required|integer",
            'total' => "required|integer",
            'payment' => "required|integer",
            'change' => "required|integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $current_prefix = Prefix::where('active', true)->first();

        $transaction = Transaction::create(
            array_merge(
                $validator->validated(),
                [
                    'prefix_id' => $current_prefix->id,
                ]
            )
        );

        // Decrement stock
        $product = Product::find($request->product_id);
        $product->decrement('stock', $request->quantity);
        $product->save();

        // Give increment 5 point user
        $user = User::find($request->user_id);
        $user->increment('point', 5);
        $user->save();

        $message = 'Transaction succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $transcation = Transaction::findOrFail($id);
            $status = 200;

            return response()->json(compact('transaction'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Transaction not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => "nullable|integer",
            'user_id' => "nullable|integer",
            'cashier_name' => "nullable|string",
            'quantity' => "nullable|integer",
            'price' => "nullable|integer",
            'total' => "nullable|integer",
            'point' => "nullable|integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $transaction = Transaction::findOrFail($id);

            $transaction->product_id = (int) $request->product_id;
            $transaction->user_id = (int) $request->user_id;
            $transaction->cashier_name = $request->cashier_name;
            $transaction->quantity = (int) $request->quantity;
            $transaction->price = (int) $request->price;
            $transaction->total = (int) $request->total;
            $transaction->point = (int) $request->point;

            $transaction->save();

            $message = 'Transaction successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Transaction not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            $transaction->delete();

            $message = 'Transaction successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Transaction not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
