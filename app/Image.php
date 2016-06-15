<?php

namespace App;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	/**
	 * variable that can be mass assigned.
     * 
	 * @var array
	 */
	protected $fillable = [
		'link',
        'thumb',
		'full',
		'caption_text',
		'profile_id',
		'image_id',
		'created_time',
		'state',
	];

	/**
	 * An image is owned by a instagram profile.
	 * 
	 * @return belongTo
	 */
	public function instagramProfile()
	{
		return $this->belongsTo('App\InstagramProfile', 'profile_id', 'profile_id');
	}

    /**
     * Scope a query to get next image id.
     *
     * @param  collection $query
     * @param  id  $id
     * @param  string  $state image state, show|hide|new, default show
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopeNextId($query, $id, $state = 'show')
	{
		return $query->where('id', '>', $id)
					 ->Where('state', '=', 'show')
					 ->orderBy('id', 'asc')
					 ->first(['id']);
	}

    /**
     * Scope a query to get prev image id.
     *
     * @param  collection $query
     * @param  id  $id
     * @param  string  $state image state, show|hide|new, default show
     * @return \Illuminate\Database\Eloquent\Builder
     */
	public function scopePrevId($query, $id, $state = 'show')
	{
		return $query->where('id', '<', $id)
					 ->Where('state', '=', 'show')
					 ->orderBy('id', 'desc')
					 ->first(['id']);
	}
}
