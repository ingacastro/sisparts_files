<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $fillable = ['documents_supplies_id', 'entity', 'comments', 'employees_users_id', 'type', 'documents_id'];
}
