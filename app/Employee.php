<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['users_id', 'number', 'buyer_number', 'seller_number', 'ext'];
    protected $primaryKey = 'users_id';

    public function user()
    {
    	return $this->hasOne('IParts\User', 'id', 'users_id');
    }
}
