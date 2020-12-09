<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ErrorImport extends Model
{
    protected $fillable = ['import', 'row', 'attribute', 'errors'];
}
