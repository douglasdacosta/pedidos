<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Clientes extends Model
{
    use HasFactory;

    public function clientes(){
        return $this->belongsTo(Pedidos::class);
    }
}
