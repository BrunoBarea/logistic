<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;


class ProdutoController extends Controller
{

    /**
     * Código para importação dos produtos. Considerando que o arquivo já está no sistema.
     * Fiz uma importação simples que é chamada por uma rota. Apenas a leitura do CSV, ignorando a primeira
     * linha que é o cabeçalho. Busca o produto pelo código SKU e caso exista atualiza o estoque, se não existir
     * cadastra. Para a resposta, retorno a quantidade de linhas que foram inseridas.
     * 
     * Aqui poderia trabalhar com o código 207 para informar quantos foram inseridos e quantos tiveram seus estoques
     * atualizados. Depende da necessidade desse retorno.
     * 
     */
    public function importarProdutos()
    { 
        $novos = 0;
        if (($handle = fopen("/var/www/html/app/Arquivos/produtos.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                if(in_array('quantity', $data))
                    continue;

                $produto = Produto::find(['sku' => $data[1]])->first();
                
                if($produto === NULL) {
                    $novos++;
                    
                    $produto = new Produto();

                    $produto->sku = $data[1];
                    $produto->client = $data[0];
                }

                $produto->quantity = $data[2];

                $produto->save();
                
            }
            fclose($handle);
        }

        return response()->json([sprintf("%s novos produtos adicionados", $novos)], 201);
    }

    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos, 200);
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if(!$produto) 
            return response()->json([], 204);

        return response()->json($produto, 200);
    }

    /**
     * método de inserção do produto. Verifica os valores SKU e Cliente como obrigatórios.
     * A quantidade não é obrigatória pois assume como default 0 no banco de dados porém quando
     * passada é verificado se é inteira.
     */
    public function insert(Request $request)
    {
        $this->validate($request, [
            'sku' => 'required|unique:produto',
            'client' => 'required',
            'quantity' => 'integer'
        ]);
        
        $produto = new Produto();

        $produto->sku = $request->sku;
        $produto->client = $request->client;
        $produto->quantity = $request->quantity;

        $produto->save();

        return response()->json($produto, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sku' => 'required|unique:produto',
            'client' => 'required',
            'quantity' => 'integer'
        ]);

        $produto = Produto::find($id);

        if(!$produto) 
            return response()->json([], 204);

        $produto->sku = $request->sku;
        $produto->client = $request->client;
        $produto->quantity = $request->quantity;

        $produto->save();

        return response()->json($produto, 200);
    }

    public function delete($id)
    {
        $produto = Produto::find($id);

        /**
         * Caso o produto informado não exista, verifica e retorna 204 para
         * que a interpretação do erro seja realizado no front. Tenho duvidas com
         * relação ao código nesse caso pois considero que o 404 seria um retorno
         * para recurso não encontrado. Deixei comentado o retorno com 404 abaixo.
         */
        if(!$produto) 
            return response()->json([], 204);
            //return response()->json(['Product not Found'], 404);

        $produto->delete();

        return response()->json(['Product %s removed!'], 200);
    }

    /**
     * Método para alterar apenas a quantidade desejada dos produtos.
     */
    public function alteraQuantity(Request $request, $id)
    { 

        $this->validate($request, [
            'quantity' => 'required|integer'
        ]);

        $produto = Produto::find($id);
        
        if(!$produto) 
            return response()->json([], 204);

        $produto->quantity = $request->quantity;

        $produto->save();

        return response()->json($produto, 200);
    }

    public function adicionarQuantity(Request $request, $id)
    { 

        $this->validate($request, [
            'quantity' => 'required|integer'
        ]);

        $produto = Produto::find($id);

        if(!$produto) 
            return response()->json([], 204);

        $produto->quantity = $produto->quantity + $request->quantity;

        $produto->save();

        return response()->json($produto, 200);
    }

    public function removerQuantity(Request $request, $id)
    { 

        $this->validate($request, [
            'quantity' => 'required|integer'
        ]);

        $produto = Produto::find($id);
        
        if(!$produto) 
            return response()->json([], 204);

        $produto->quantity = $produto->quantity - $request->quantity;

        $produto->save();

        return response()->json($produto, 200);
    }

}
