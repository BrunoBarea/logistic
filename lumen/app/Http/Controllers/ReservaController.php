<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
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
        $reservas = Reserva::all();

        return response()->json($reservas, 200);
    }

    public function show($id)
    {
        $reserva = Reserva::find($id);

        if(!$reserva) 
            return response()->json([], 204);

        return response()->json($reserva, 200);
    }

    public function insert(Request $request)
    {
        //Valida os parametros necessarios
        $this->validate($request, [
            'sku' => 'required',
            'quantity' => 'integer'
        ]);
        
        //Busca o produto pelo codigo
        $produto = Produto::where('sku', $request->sku)->first();
        
        //Se não encontrar o produto retorna 204
        if(!$produto)
            return response()->json([], 204);

        //Verifica se a quantidade de produtos em estoque é menor ou igual a quantidade de produtos solicitada
        if($produto->quantity >= $request->quantity) {
            //Cria a reserva
            $reserva = new Reserva();
            $reserva->sku = $produto->sku;
            $reserva->quantity = $request->quantity;
            $reserva->save();

            //Diminui o estoque do produto
            $produto->quantity = $produto->quantity - $request->quantity;
            $produto->save();

            return response()->json($reserva, 201);
        }

        //Nesse caso coloquei como 409 para considerar também erro de regra de negócio. No outro método eu coloco 
        //o código 204 mesmo.
        return response()->json(["Quantidade disponível menor que a solicitada."], 409);
    }

    public function delete($id)
    {
        $reserva = Reserva::find($id);

        if(!$reserva) 
            return response()->json([], 204);

        $produto = Produto::where('sku', $reserva->sku)->first();
        $produto->quantity = $produto->quantity + $reserva->quantity;
        $produto->save();
        
        $reserva->delete();

        return response()->json([sprintf('Reserva %s cancelada!', $id)], 200);
    }

}
