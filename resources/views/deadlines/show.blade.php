@extends('layouts.app')

@section('content')
    <a href="/deadlines" class="btn btn-default">Go Back</a>
    <h1>{{$deadline->title}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$deadline->cover_image}}">
    <br><br>
    <div>
        {!!$deadline->body!!}
    </div>
    <hr>
    <small>Written on {{$deadline->created_at}} by {{$deadline->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $deadline->user_id)
            <a href="/deadlines/{{$deadline->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['AdminController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
@endsection