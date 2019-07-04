<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	//protected $primaryKey = 'users_id';
    protected $fillable = ['code', 'trade_name', 'business_name', 'post_code', 'state', 'country', 'sync_connections_id'];
}
