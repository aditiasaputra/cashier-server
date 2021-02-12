<?php

namespace App\Http\Controllers;

use App\Models\{Gift, ClaimGift, User};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClaimGiftController extends Controller
{
    /**
     * Create a new Claim Gift Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('jwt.verify');
        $this->middleware('token.verify');
        $this->middleware(['role:cashier'], ['only' => ['update', 'destroy']]);
    }

    public function index(Request $request)
    {
        $claim_gifts = ClaimGift::all()->latest();

        $status = 200;

        return response()->json(compact('claim_gifts'), $status);
    }

    public function store(Request $request)
    {
        $gift = Gift::find($request->gift_id);
        $user = User::find($request->user_id);

        if ($user->point < $gift->point) {
            return response()->json(['message' => 'You\'ve not enough points!']);
        }

        $validator = Validator::make($request->all(), [
            'gift_id' => "required|integer",
            'user_id' => "required|integer",
            'quantity' => "required|integer",
            'total_point' => "required|integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $claim_gift = ClaimGift::create(array_merge($validator->validated()));

        // Decrement user point
        $user->decrement('point', (int) $request->total_point);
        $user->save();

        // Decrement gift stock
        $gift->decrement('stock', (int) $request->quantity);
        $gift->save();

        $message = 'Claim gift succesfully created!';
        $status = 200;

        return response()->json(compact('message'), $status);
    }

    public function show($id)
    {
        try {
            $claim_gift = ClaimGift::findOrFail($id);
            $status = 200;

            return response()->json(compact('Claim gift'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Claim gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gift_id' => "nullable|integer",
            'user_id' => "nullable|integer",
            'quantity' => "nullable|integer",
            'total_point' => "nullable|integer",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $claim_gift = ClaimGift::findOrFail($id);

            $claim_gift->product_id = (int) $request->product_id;
            $claim_gift->customer_user_id = (int) $request->customer_user_id;
            $claim_gift->cashier_user_id = (int) $request->cashier_user_id;
            $claim_gift->price = (int) $request->price;
            $claim_gift->total = (int) $request->total;
            $claim_gift->point = (int) $request->point;

            $claim_gift->save();

            $message = 'Claim gift successfully updated!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Claim gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }

    public function destroy($id)
    {
        try {
            $claim_gift = ClaimGift::findOrFail($id);

            $claim_gift->delete();

            $message = 'Claim gift successfully deleted!';
            $status = 200;

            return response()->json(compact('message'), $status);
        } catch (ModelNotFoundException $e) {
            $message = 'Claim gift not found!';
            $status = 404;

            return response()->json(compact('message'), $status);
        }
    }
}
