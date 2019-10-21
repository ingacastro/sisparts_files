<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'exchange_rate'];
}
