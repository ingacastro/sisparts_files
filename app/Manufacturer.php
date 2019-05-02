<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = ['name', 'document_type', 'siavcom_key_xmd'];
}
