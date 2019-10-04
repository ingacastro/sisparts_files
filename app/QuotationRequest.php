<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    protected $table = 'quotations_requests';
    protected $fillable = ['documents_supplies_id'];

    public function suppliers()
    {
    	return $this->belongsToMany('IParts\Supplier', 'quotations_requests_suppliers', 'quotations_requests_id', 'suppliers_id');
    }
}
