<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
   	public function sets()
   	{
   		return $this->belongsToMany('IParts\SupplySet', 'documents_supplies_files', 'documents_supplies_id', 'files_id');
   	}
}
