@extends('layouts.app')

@section('content')

<div class="container">
    <div class='studio margin'>
        <div class='zone-videos'>
            <h2>{{ __('last_videos') }}</h2>
            @foreach($videos as $video)
            <div class='video'>
                <div class='professional'>

                    <span><a href="{{ url('professional/'.$video->professional->id.'/'.$video->professional->slug) }}">
                     <img class='avatar-round' src="{{  url('images/avatar/crop/'.$video->professional->getSetting('avatar')) }}" />{{ $video->professional->surname }}
                    </a></span>
                </div>
                <iframe width="420" height="315" src="https://www.youtube.com/embed/{{ $video->url }}">
                </iframe>
            </div>
            @endforeach
        </div>
    </div>
</div>
       
@endsection