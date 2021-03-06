@extends('layouts.admin')

@section('content')

	<h1>Categories</h1>
	<div class="col-sm-6">
		@if($categories)
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Created Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
					<tr>
						<td>{{$category->id}}</td>
						<td>{{$category->name}}</td>
						<td>{{$category->created_at ? $category->created_at->diffForHumans() : 'no date'}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
	
	<div class="col-sm-6">
		<h3>Create Category</h3>
		{!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}
		
			<div class="form-group">
				{!! Form::label('name', 'Name:') !!}
				{!! Form::text('name', null, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
			</div>
			
		{!! Form::close() !!}
	</div>
	
@stop