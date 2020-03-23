<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Selectlistauth extends Model
{
    protected $table = 'selectlist_edit';
    protected $fillable = ['name','status'];
}
