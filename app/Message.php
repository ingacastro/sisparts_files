<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['languages_id', 'title', 'subject', 'body'];

    public function language()
    {
    	return $this->belongsTo('IParts\Language', 'languages_id');
    }
}
