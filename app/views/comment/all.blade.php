@extends('layouts.page')

@section('title')
All Comments
@stop

@section('content')

<h2>All Comments!</h2>

@if ($comments->isEmpty())
	<p>No comments yet. {{ link_to_route('comment.create', 'Add one') }}?</p>
@else
	<div class="comments">
		<ul>
		@foreach ($comments as $comment)
			<li>
				<p class="email">{{ $comment->email }}</p>
				<p class="comment">{{ $comment->content }}</p>
				<p class="updated_at">{{ $comment->updated_at }}</p>
			</li>
		@endforeach
		</ul>
	</div>
@endif

@stop