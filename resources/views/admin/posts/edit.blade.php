@extends('layouts.admin');

@section('content')

<h1>Edit Post Post</h1>


{!! Form::model(['method'=>'PATCH', 'action'=>['AdminPostsController@update', $post->id], 'files'=>true]) !!}

<div class="form-group">
	{!! Form::label('title', 'Title:') !!}
	{!! Form::text('title', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('category_id', 'Category:') !!}
	{!! Form::select('category_id', [''=>'Choose Categories'] + $categories, null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('photo_id', 'Photo:') !!}
	{!! Form::file('photo_id') !!}
</div>

<div class="form-group">
	{!! Form::label('body', 'Description:') !!}
	{!! Form::textarea('body', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::submit('Create Post', ['class'=>'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

	@include('includes.form_error')

@stop

@stop