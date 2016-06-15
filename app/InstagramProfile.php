<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstagramProfile extends Model
{
	/**
	 * variable that can be mass assigned.
     * 
	 * @var array
	 */
	protected $fillable = [
		'name',
		'profile_id',
	];

    /**
     * An Instagram Profile can have many images.
     * 
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Image', 'profile_id', 'profile_id');
    }
}
