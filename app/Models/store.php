<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class store extends Model
{

public $timestamps = false;
    protected $table = 'store';

    protected $fillable = [
        'category',
        'name',
        'description',
        'price',
        'image',
    ];
}
