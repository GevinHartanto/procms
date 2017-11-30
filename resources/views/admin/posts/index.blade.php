@extends('layouts.admin');

@section('content')

<h1>Posts</h1>

<table class="table">
	<thead>
		<tr>
			<th>ID</td>
			<th>User</td>
			<th>Category</td>
			<th>Photo</td>
			<th>Title</td>
			<th>Body</td>
			<th>Created</td>
			<th>Updated</td>
		</tr>
	</thead>
	<tbody>
		@if($posts)
				@foreach($posts as $post)
			<tr>
				<td>{{$post->id}}</td>
				<td>{{$post->user->name}}</td>
				<td>{{$post->category_id}}</td>
				<td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
				<td><img height="50" src="{{$post->photo ? $post->photo->file : 'http://placehold.it/400x400'}}" /></td>
				<td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
				<td>{{$post->body}}</td>
				<td>{{$post->created_at->diffForHumans()}}</td>
				<td>{{$post->updated_at->diffForHumans()}}</td>
			</tr>
				@endforeach
			@endif
		</tbody>
	</thead>
</table>

@stop