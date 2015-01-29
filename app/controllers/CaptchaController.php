<?php

/**
 * Captcha Controller
 *
 * CAPTCHA generator
 */
class CaptchaController extends Controller
{
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		$this->beforeFilter('captcha');
	}

	/**
	 * Displays CAPTCHA image
	 *
	 * @return Generated CAPTCHA as PNG
	 */
	public function show()
	{
		$text = Session::get('captcha');

		$image = $this->generate(280, 140, $text);

		ob_start(); // start output buffering

		imagepng($image); // output PNG to buffer
		$imageString = ob_get_contents(); // get buffered image string

		ob_end_clean(); // clear output buffer

		imagedestroy($image); // clear image resource allocations

		return Response::make(
			$imageString,
			200,
			['Content-Type' => 'image/png']
		);
	}

	/**
	 * Generate CAPTCHA image resource
	 *
	 * @param width  generated image width
	 * @param height generated image height
	 * @param text   CAPTCHA text
	 *
	 * @return Resource CAPTCHA image
	 */
	private function generate($width, $height, $text)
	{
		$image  = imagecreate($width, $height);
		$font   = app_path() . '/internal/fonts/Black_Casper.ttf';

		$colors = [];
		$colors['background'] = $this->lightColorRand($image, $colors);
		$colors['text']       = $this->lightColorRand($image, $colors);
		$colors['noise']      = $this->lightColorRand($image, $colors);
		$colors['black']      = imagecolorallocate($image, 0, 0, 0);

		imagefill(
			$image, 0, 0, $colors['background']
		);

		imagesetthickness($image, $width / 6);

		foreach (range(0, 5) as $i)
		{
			imageline(
				$image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $colors['noise']
			);
			imageline(
				$image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $colors['background']
			);
			imageline(
				$image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $colors['text']
			);
		}

		imagettftext(
			$image, ($width / 5), 21, $width / 5, $height -5, $colors['black'], $font, $text
		);
		imagettftext(
			$image, ($width / 5), 22, $width / 5, $height -5, $colors['black'], $font, $text
		);
		imagettftext(
			$image, ($width / 5), 23, $width / 5, $height -5, $colors['black'], $font, $text
		);
		imagettftext(
			$image, ($width / 5) -1, 22, $width / 5, $height -5, $colors['text'], $font, $text
		);

		return $image;
	}

	/**
	 * Get random light toned color
	 *
	 * @param image  Resource image
	 * @param except Color array exceptions
	 *
	 * @return random light color that does not exist in except array
	 */
	private function lightColorRand($image, $except = array())
	{
		$except = array_values($except);

		do
		{
			$color = imagecolorallocate(
				$image, rand(55, 255), rand(55, 255), rand(55, 255)
			);
		}
		while (in_array($color, $except));

		return $color;
	}
}
