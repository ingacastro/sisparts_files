<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = ['path', 'supplier', 'url'];

   	public function supplies()
   	{
   		return $this->belongsToMany('IParts\Supply', 'supplies_files', 'files_id', 'supplies_id');
   	}
}
