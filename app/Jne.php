<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jne extends Model
{
    protected $table = 'jne';
    protected $fillable = [
        'tanggal','no_resi', 'reg','oke', 
        'yes','service', 'ass','pengirim', 
        'penerima','tujuan'
    ];
}
