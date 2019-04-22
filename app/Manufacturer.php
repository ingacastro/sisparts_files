<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
	protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'document_type'];
}
