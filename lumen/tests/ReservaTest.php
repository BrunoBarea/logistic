<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Reserva;
use App\Models\Produto;

class ReservaTest extends TestCase
{
    public function testTodasReservas()
    {
        $response = $this->call('GET', '/reserva');

        return $this->assertEquals(200, $response->status());
    }
    
    public function testUmaReserva()
    {
        $reserva = Reserva::all();
        
        $response = $this->call('GET', sprintf('/reserva/%d', $reserva->first()->id));

        return $this->assertEquals(200, $response->status());
    }
    
    public function testInsert()
    {
        $produtos = Produto::all();

        $response = $this->call('POST', '/reserva', ['quantity' => 2, 'sku' => $produtos->first()->id]);

        return $this->assertEquals(201, $response->status());
    }
    
    public function testDelete()
    {
        $reserva = Reserva::all();
        
        $response = $this->call('DELETE', sprintf('/reserva/%d', $reserva->first()->id));

        return $this->assertEquals(200, $response->status());
    }
    
}
