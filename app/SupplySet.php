<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class SupplySet extends Model
{
    protected $table = 'documents_supplies';
    protected $fillable = ['status', 'documents_id', 'supplies_id'];

    public function document()
    {
    	return $this->hasOne('IParts\Document', 'id', 'documents_id');
    }
    public function supply()
    {
    	return $this->hasOne('IParts\Supply', 'id', 'supplies_id');
    }
}
