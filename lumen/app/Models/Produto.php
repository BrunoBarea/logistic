<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';

    protected $primary = 'id';

    protected $fillable = [
        'sku', 'cliente', 'quantity'
    ];

    public static $rules = [
        'sku' => 'required|max:120',
        'client' => 'required|max:120',
        'quantity' => 'required|numeric'
    ];
}
