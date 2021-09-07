<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Produto;

class ProdutoTest extends TestCase
{
    public function testTodosProdutos()
    {
        $response = $this->call('GET', '/produto');

        return $this->assertEquals(200, $response->status());
    }
    
    public function testUmProduto()
    {
        $produto = Produto::all();
        
        $response = $this->call('GET', sprintf('/produto/%d', $produto->first()->id));

        return $this->assertEquals(200, $response->status());
    }
    
    public function testInsert()
    {
        $response = $this->call('POST', '/produto', ['client' => 'LojaTeste', 'sku' => 'teste_123', 'quantity' => '20']);

        return $this->assertEquals(201, $response->status());
    }
    
    public function testUpdate()
    {
        $produto = Produto::all();
        
        $response = $this->call('PUT', sprintf('/produto/%d', $produto->first()->id), ['client' => 'LojaTeste2', 'quantity' => '15']);

        return $this->assertEquals(200, $response->status());
    }
    
    public function testDelete()
    {
        $produto = Produto::all();
        
        $response = $this->call('DELETE', sprintf('/produto/%d', $produto->first()->id));

        return $this->assertEquals(200, $response->status());
    }
    
    public function testEstoque()
    {
        $produto = Produto::all();
        
        $response = $this->call('PATCH', sprintf('/produto/%d', $produto->first()->id), ['quantity' => 200]);

        return $this->assertEquals(200, $response->status());
    }
    
    public function testAumentaEstoque()
    {
        $produto = Produto::all();
        
        $response = $this->call('PATCH', sprintf('/produto/adicionar/%d', $produto->first()->id), ['quantity' => 200]);

        return $this->assertEquals(200, $response->status());
    }
    
    public function testDiminuiEstoque()
    {
        $produto = Produto::all();
        
        $response = $this->call('PATCH', sprintf('/produto/remover/%d', $produto->first()->id), ['quantity' => 200]);

        return $this->assertEquals(200, $response->status());
    }
}
