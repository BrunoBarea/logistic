<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'sku', 'quantity', 'data_add', 'data_upd'
    ];

    public static $rules = [
        'sku' => 'required|string|exists:produto,sku',
        'client' => 'required|max:120',
        'quantity' => 'required|numeric'
    ];

    public function produto()
    {
        return $this->belongsTo("App\Models\Produto");
    }
}
