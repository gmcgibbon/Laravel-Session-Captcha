<?php

// captcha macro

Form::macro('textCaptcha', function($name, $labelOptions = [], $inputOptions = [])
{
	//array_push($inputOptions, 'required');

	$captcha = HTML::image(route('captcha.show'), 'captcha');
	$label   = Form::label($name, 'Answer:', $labelOptions);
	$text    = Form::input('text', $name, '', $inputOptions);
    return $captcha . '<br>' . $label . $text;
});