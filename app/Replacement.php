<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Replacement extends Model
{
    protected $fillable = ['description', 'supplies_id'];
}
