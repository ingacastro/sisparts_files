<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['type','number','reference','customer_code','seller_number','state',
    					   'currency_id','mxn_currency_exchange_rate','customer_requirement_number',
    					   'buyer_name','buyer_number','customers_id'];
}
