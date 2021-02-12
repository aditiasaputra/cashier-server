<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Create a new Auth Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('jwt.verify', ['only' => ['profile']]);
        $this->middleware('token.verify');
        $this->middleware(['role:cashier'], ['only' => ['show', 'update', 'destroy']]);
    }
}
