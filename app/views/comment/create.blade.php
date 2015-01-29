@extends('layouts.page')

@section('title')
Post Comment
@stop

@section('content')

	<h2>Post a Comment!</h2>

	{{ Form::model($comment, ['route' => 'comment.add']) }}

		@if ($errors->any())
			<div class="errors">
				<h3>Error</h3>
				<ul>
				@foreach ($errors->toArray() as $error)
					<li>{{ $error[0] }}</li>
				@endforeach
				</ul>
			</div>
		@endif
		
		<br>
		{{ Form::label('email', 'Email:') }}
		{{ Form::text ('email', '', ['autofocus']) }}
		<br>
		{{ Form::label('content', 'Comment:') }}
		{{ Form::textarea ('content') }}
		<br>
		{{ Form::textCaptcha('captcha') }}
		<br>
		{{ Form::submit('Submit') }}

	{{ Form::close() }}

@stop