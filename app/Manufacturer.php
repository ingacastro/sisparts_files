<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['name', 'document_type', 'siavcom_key_xmd'];

	public function suppliers()
    {
    	return $this->belongsToMany('IParts\Supplier', 'suppliers_manufacturers', 'manufacturers_id', 'suppliers_id');
    }

    public function supplies()
    {
    	return $this->hasMany('IParts\Supply', 'manufacturers_id', 'id');
    }
}
