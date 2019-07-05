<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	//protected $primaryKey = 'users_id';
<<<<<<< HEAD
    protected $fillable = ['code', 'trade_name', 'business_name', 'post_code', 'state', 'country', 'sync_connections_id', 'type'];
    public $types = [
			'' => 0, //MEANS NOTHING
			'EX' => 1, //Foreing customer. No IVA.
			'PG' => 2, //Publico en general. 16% IVA.
			'PF' => 3, //Persona física. 16% IVA.
			'AA' => 4, //UNKNOWN.
			'PV' => 5, //UNKNOWN.
			'IN' => 6, //UNKNOWN.
			'AD' => 7, //UNKNOWN.
			'PE' => 8, //UNKNOWN.
			'PM' => 9 //Persona moral. 16% IVA.
    	];

    public function setTypeAttribute($value)
    {
    	$this->attributes['type'] = $this->types[$value];
    }
=======
    protected $fillable = ['code', 'trade_name', 'business_name', 'post_code', 'state', 'country', 'sync_connections_id'];
>>>>>>> bcb3529f8d5412b84105d5884c5f50c4b9770d0e
}
