@extends('layouts.page')

@section('meta')
<meta 
	http-equiv="refresh" 
	content="{{ CaptchaHelper::FAIL_LOCK_TIME * 60 }}">
@stop

@section('title')
Locked Out
@stop

@section('content')

	<h2>Locked Out</h2>

	<p>You have been temporarily locked out for {{ CaptchaHelper::FAIL_LOCK_TIME }} minutes.</p>

	{{ HTML::image('https://openclipart.org/image/300px/svg_to_png/4502/johnny_automatic_cat_reading.png', 'Cat Reading!') }}

@stop