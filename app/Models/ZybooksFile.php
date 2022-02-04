<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZybooksFile extends Model
{
    use HasFactory;

    protected $casts = [
        'parsed' => 'array'
    ];
}
