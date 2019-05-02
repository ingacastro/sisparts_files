<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['trade_name','countries_id','email','languages_id','landline','currencies_id','mobile','marketplace','business_name','type','states_id','rfc','city','post_code','street','contact_name','street_number','unit_number','credit_days','credit_amount','suburb'];

    public function brands()
    {
    	return $this->belongsToMany('IParts\Manufacturer', 'suppliers_manufacturers', 'suppliers_id', 'manufacturers_id');
    }
}
