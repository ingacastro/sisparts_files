<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class SupplySet extends Model
{
    protected $table = 'documents_supplies';
    protected $fillable = ['documents_id', 'supplies_id', 'suppliers_id', 'currencies_id', 'sale_unit_cost',
                            'importation_cost', 'warehouse_shipment_cost', 'customer_shipment_cost', 'extra_charges', 
                            'notes', 'source_country_id', 'utility_percentages_id', 'custom_utility_percentage', 'status', 
                            'completed_date', 'unit_price', 'quotation_request_date'];

    public function document()
    {
    	return $this->hasOne('IParts\Document', 'id', 'documents_id');
    }
    public function supply()
    {
    	return $this->hasOne('IParts\Supply', 'id', 'supplies_id');
    }

    public function rejections()
    {
        return $this->belongsToMany('IParts\RejectionReason', 'rejections', 'documents_supplies_id', 'rejection_reasons_id');
        //->withPivot('comments');
    }

    public function currency()
    {
        return $this->hasOne('IParts\Currency', 'id', 'currencies_id');
    }

    public function utility_percentage()
    {
        return $this->hasOne('IParts\UtilityPercentage', 'id', 'utility_percentages_id');
    }
}

