<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    protected $fillable = ['description', 'supplies_id'];
}
