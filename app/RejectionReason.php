<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
	protected $fillable = ['title'];

	public function rejections()
	{
		return $this->hasMany('IParts\Rejection', 'rejection_reasons_id');
	}
}