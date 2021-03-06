<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function languages()
    {
    	return $this->belongsToMany('IParts\Language', 'messages_languages', 'messages_id', 'languages_id')
    	->withPivot('title', 'subject', 'body');
    }
}
