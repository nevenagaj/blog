@extends('main')

@section('title', '| Edit Tag')

@section('content')

    {{ Form::model($tag, ['route'=>['tags.update', $tag->id], 'method'=>"PUT"]) }}
    <!-- prvi parametar $tag pokazuje koji model iz kontrolera zelis da editujes, 
        posto model() sam popunjava parametre-->

        {{ Form::label('name', "Title:") }}
        {{ Form::text('name', null, ['class'=>'form-control']) }}

        {{ Form::submit('Save changes', ['class'=>'btn btn-success']) }}

    {{ Form::close() }}

@endsection