<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $fillable = ['path', 'manufacturer', 'url'];

   	public function sets()
   	{
   		return $this->belongsToMany('IParts\SupplySet', 'documents_supplies_files', 'files_id', 'documents_supplies_id');
   	}
}
