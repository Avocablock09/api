<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Geographical;

class perjalanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_perjalanan',
        'longitude',
        'latitude'
    ];
}
