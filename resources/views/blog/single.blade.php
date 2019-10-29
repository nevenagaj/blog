@extends('main')
<?php $titleTag = htmlspecialchars($post->title); ?>


@section('title', "| $titleTag")

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<img src="{{ asset('images/' . $post->image) }}" alt="">
			<h1>{{ $post->title }}</h1>
			<p>{!! $post->body !!}</p>
			<hr>
			<p>Posted In: {{ $post->category->name }}</p>
		</div>
	</div> <!-- end of row-->
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@foreach($post->comments as $comment )
				<div class="comment">
					<p><strong>Name:</strong> {{ $comment->name}}</p>
					<p><strong>Comment:</strong><br>{{ $comment->comment }}</p><br><br><br>
				</div>
			@endforeach
		</div>
	</div>
	<div class="row">
		<div id="comment-form" class="col-md-8 coll-md-offset-2">
			{{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}
				<div class="row">
					<div class="col-md-6">
						{{ Form::label('name', 'Name:') }}
						{{ Form::text('name', null, ['class' => 'form-control']) }}
					</div>
					<div class="col-md-6">
						{{ Form::label('email', 'Email:') }}
						{{ Form::text('email', null, ['class' => 'form-control'])}}
					</div>
					<div class="col-md-12">
						{{ Form::label('comment', 'Commebt:') }}
						{{ Form::textarea('comment', null, ['class' => 'form-control'])}}

						{{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block']) }}
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>

@endsection