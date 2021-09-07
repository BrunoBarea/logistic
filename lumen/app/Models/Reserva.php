<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';

    protected $fillable = [
        'sku', 'quantity'
    ];

    public static $rules = [
        'sku' => 'required|string|exists:produto,sku',
        'quantity' => 'required|numeric'
    ];

    public function produto()
    {
        return $this->belongsTo("App\Models\Produto");
    }
}
