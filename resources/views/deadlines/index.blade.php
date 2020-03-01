@extends('layouts.app')

@section('content')
    <h1>Deadlines</h1>
    @if(count($deadlines) > 0)
        @foreach($deadlines as $deadline)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                    <h3><{{$deadline->name}} at {{$deadline->date}}</h3>
                        <small>Last Updated on {{$deadline->created_at}}</small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection