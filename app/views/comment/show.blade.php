@extends('layouts.page')

@section('title')
Comment {{ $comment->id }}
@stop

@section('content')

<h2>Comment {{ $comment->id }}</h2>

@stop