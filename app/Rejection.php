<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    protected $fillable = ['comments', 'documents_supplies_id', 'rejection_reasons_id'];
}
