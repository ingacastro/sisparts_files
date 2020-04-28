<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class GlobalSupplier extends Model
{
    protected $fillable = ['name', 'country_id', 'email', 'language_id', 'telephone', 'currency_id', 'phone', 'marketplace', 'brokers_pais'];
}
