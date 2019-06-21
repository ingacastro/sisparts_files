<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class SupplySet extends Model
{
    protected $table = 'documents_supplies';
    protected $fillable = ['status'];

    public function document()
    {
    	return $this->hasOne('IParts\Document', 'id', 'documents_id');
    }
}
