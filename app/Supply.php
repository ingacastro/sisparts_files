<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = ['number', 'manufacturers_id', 'short_description', 'large_description', 'tax'];

    public function manufacturer()
    {
    	return $this->hasOne('Iparts\Manufacturer', 'id', 'manufacturers_id');
    }
/*    public function files()
    {
		return $this->belongsToMany('IParts\File', 'supplies_files', 'supplies_id', 'files_id');
    }*/

/*    public function documents()
    {
		return $this->belongsToMany('IParts\Document', 'documents_supplies', 'supplies_id', 'documents_id')
   		->withPivot('set', 'product_description', 'product_amount', 'measurement_unit_code', 'sale_unit_cost');
    }*/
}
