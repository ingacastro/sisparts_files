<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class Checklistauth extends Model
{
    protected $table = 'checklist_edit';
    protected $fillable = ['name','checklist_column','status','help'];
}
