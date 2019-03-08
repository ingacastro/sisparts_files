<?php

namespace IParts;

use Illuminate\Database\Eloquent\Model;

class ColorSetting extends Model
{
    protected $fillable = ['color', 'days', 'emails'];

    public function emails()
    {
    	return $this->hasMany('\IParts\ColorSettingEmail', 'color_settings_id');
    }
}
