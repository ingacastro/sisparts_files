<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['type','number','reference','customer_code','seller_number','state',
    					   'currency_id','mxn_currency_exchange_rate','customer_requirement_number',
    					   'buyer_name','buyer_number','customers_id', 'sync_connections_id', 'employees_users_id'];

   	public function supplies()
   	{
   		return $this->belongsToMany('IParts\Supply', 'documents_supplies', 'documents_id', 'supplies_id')
   		->withPivot('set', 'product_description', 'products_amount', 'measurement_unit_code', 'sale_unit_price');
   	}

   	public function quoter()
   	{
   		return $this->hasOne('IParts\Employee', 'employees_users_id');
   	}
}
