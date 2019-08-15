<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['title', 'recipients', 'subject', 'message', 'type', 'elapsed_days', 'set_status'];
}
