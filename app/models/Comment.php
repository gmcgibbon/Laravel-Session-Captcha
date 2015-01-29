<?php

use Carbon\Carbon;

use LaravelBook\Ardent\Ardent;

/**
 * Comment model
 * 
 */
class Comment extends Ardent
{
	const DATE_FORMAT = 'F j, Y, g:i a';

	/**
	 * Ardent validation rules
	 */
	public static $rules =
	[
	  'email'   => 'required|email',
	  'content' => 'required|min:1',
	];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

	/**
	 * Define accessible fileds
	 *
	 */
	protected $fillable = array('email', 'content');

	/**
	 * Get created at attribute date formatted
	 * 
	 * @param attr attribute value to format
	 * 
	 * @return formatted created at date string
	 */
	public function getCreatedAtAttribute($attr)
	{

		return Carbon::parse($attr)->format(self::DATE_FORMAT);
	}

	/**
	 * Get updated at attribute date formatted
	 * 
	 * @param attr attribute value to format
	 * 
	 * @return formatted updated at date string
	 */
	public function getUpdatedAtAttribute($attr)
	{

		return Carbon::parse($attr)->format(self::DATE_FORMAT);
	}
}
