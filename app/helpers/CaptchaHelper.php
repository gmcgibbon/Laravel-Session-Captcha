<?php

/**
 * Captcha Helper
 * 
 * Provides CAPTCHA validation and 
 * status methods to controllers
 */
class CaptchaHelper
{
	const FAIL_MAX_COUNT = 5;  // max attempts
	const FAIL_SPAN_TIME = 30; // seconds
	const FAIL_LOCK_TIME = 3;  // mins

	private static $instance; // singleton instance

	private $now; // timestamp

	/**
	 * Constructor
	 * 
	 */
	public function __construct()
	{
		$this->now = time();
	}

	/**
	 * Validation status info
	 * 
	 * @return Time left before reset 
	 * 		   and attempt count left
	 */
	public function status()
	{
		$now       = $this->now;
		$time      = Cookie::get('captcha_fail_time', $now);
		$timeLeft  = self::FAIL_SPAN_TIME - ($now - $time);
		$count     = Cookie::get('captcha_fail_count', 1);
		$countLeft = self::FAIL_MAX_COUNT - $count;

		return
			[
				'time_left'  => $timeLeft,
				'count_left' => $countLeft,
			];
	}

	/**
	 * Determines if current captcha challenge 
	 * matches expected captcha case insensitive
	 * 
	 * @return True if challenge matches captcha, false if not
	 */
	public function validate()
	{
		$actual   = Input::get('captcha', '');
		$expected = Session::get('captcha', '?');

		$valid = strtolower($expected) === strtolower($actual);

		if ($valid)
		{
			self::pass();
		}
		else
		{
			self::fail();
		}

		return $valid;
	}
	
	/**
	 * Clear fail cookies
	 * 
	 */
	private function pass()
	{
		Cookie::forget('captcha_fail_count');
		Cookie::forget('captcha_fail_time');
	}

	/**
	 * Requeue fail cookies
	 * 
	 */
	private function fail()
	{
		$now   = $this->now;
		$time  = Cookie::get('captcha_fail_time',  $now);
		$count = Cookie::get('captcha_fail_count', 1);
		$diff  = $now - $time;
		$exp   = (self::FAIL_SPAN_TIME - $diff) /60;

		if ($count >= self::FAIL_MAX_COUNT && $diff <= self::FAIL_SPAN_TIME)
		{
			Cookie::queue('lockout', 'captcha_lock', self::FAIL_LOCK_TIME);
		}
		else
		{
			Cookie::queue('captcha_fail_time',    $time, $exp);
			Cookie::queue('captcha_fail_count', ++$count, $exp);
		}
	}

	/**
	 * Get single instance of CaptchaHelper
	 * 
	 * @return CaptchaHelper instance
	 */
	public static function getInstance()
	{
		if (!isset(self::$instacne))
		{
			self::$instance = new CaptchaHelper();
		}	

		return self::$instance;
	}
}