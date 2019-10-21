<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    $fillable = ['name', 'exchange_rate'];
}
