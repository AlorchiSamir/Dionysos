@extends('layouts.app')

@section('content')
<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item active">{{ __('interests') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class="container">
	@include('users.interactions.options')
    <div id='zone-interactions'>
        <ul>
            <li><a href="{{ url('/interaction/interest?cat='.$_GET['cat']) }}">{{ __('interest') }}</a></li> - 
            <li><a href="{{ url('/interaction/like?cat='.$_GET['cat']) }}">{{ __('like') }}</a></li>
        </ul>
        <h2>{{ __($type) }}</h2>
        <div class='zone-links'>
            <ul>
                @if(in_array('professional', $types))
                <li><a href='?cat=professional' class='btn btn-primary'>{{ __('professionals') }}</a></li>
                @endif
                @if(in_array('company', $types))
                <li><a href='?cat=company' class='btn btn-primary'>{{ __('companies') }}</a></li>
                @endif
                @if(in_array('hall', $types))
                <li><a href='?cat=hall' class='btn btn-primary'>{{ __('halls') }}</a></li>
                @endif
            </ul>
        </div>
        <div id='zone-result'>
            @include('users.interactions.list')
        </div>
    </div>
</div>

<script type="text/javascript">
    
$(document).ready(function() {
    var s = $(".zone-links");
    var p = $('#zone-interactions');
    var pos = s.position();                   
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top) {
            s.addClass("fixed");
            p.addClass('cor-fixed');
        } else {
            s.removeClass("fixed");
            p.removeClass('cor-fixed');
        }
    });
});

</script>


@endsection