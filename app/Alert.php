<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['title', 'recipients', 'subject', 'message', 'type', 
    'supplies_sets_status_id', 'elapsed_days'];
}
