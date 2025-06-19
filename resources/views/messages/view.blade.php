@extends('layouts.app')

@section('content')
<div class='mini-banner'>
  <div class="container">
      <ol class="breadcrumb-nav">
          <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
          <li class='breadcrumb-item'><a href="{{ url('/messages') }}">{{ __('messages') }}</a></li>
          <li class="breadcrumb-item active">{{ $message->title }}</li>
      </ol>
  </div>
</div>
<div class='container message view'>
  <h3>{{ __('message') }}</h3>
	<div class='content'>
		{{ $message->content }}
	</div>
  @if(count($message->messages) == 0)
	<form id='message-pro-form' method="POST" action="{{ url('message/send') }}" enctype="multipart/form-data">         
        @csrf          
        <input type="hidden" name="message_id" value='{{ $message->id }}'>
        <input type="hidden" name="original_title" value='{{ $message->title }}'>
        <div class="form-group row">
            <label for="content" class="col-md-2 col-form-label">{{ __('answer') }}</label>
            <div class="col-md-12">
                <textarea class="form-control" name='content'></textarea>
            </div>
        </div>         
        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">{{ __('send') }}</button>
            </div>
        </div>      
    </form>
    @else
    <h3>{{ __('your_reply') }}</h3>
    <div class='content'>
      {{ $message->messages[0]->content }}
    </div>
    @endif

</div>
@endsection