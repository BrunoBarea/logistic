<?php

namespace App\Http\Controllers;

class ProdutoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json([], 200);
    }

    public function show()
    {
        return response()->json([], 200);
    }

    public function insert()
    {
        return response()->json([], 201);
    }

    public function update()
    {
        return response()->json([], 200);
    }

    public function delete()
    {
        return response()->json([], 200);
    }
}
