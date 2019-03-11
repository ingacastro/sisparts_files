<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['languages_id', 'employees_users_id', 'title', 'subject', 'body'];
}
