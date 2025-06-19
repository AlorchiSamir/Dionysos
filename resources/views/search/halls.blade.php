@extends('layouts.app')

@section('content')

<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item active">{{ __('search') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class='container'>    
	<section id='zone-halls'>
        <div id='results'>
            @if(isset($city))
                <h2>{{ __('hall_owner').' '.__('from').' '.$city }}</h2>
            @else
                <h2>{{ __('hall_owner') }}</h2>
            @endif
            <input type="text" name="name" id='searchbyname' value='<?= (isset($_GET['name'])) ? $_GET['name'] : '' ?>'
                   placeholder='Recherche par nom' autocomplete="off">
            @if(count($halls) > 0)
            <div id='zone-list'>
                @include('halls.list')
                {{ $halls->appends(request()->except('page')) }}
            </div>
        </div>
        @else
            <div>{{ __('no_result') }} {{ __('from') }} {{ $city }}</div>
        @endif
        @if(count($other_halls) > 0)
        <div id='other_results'>
            <h2>{{ __('other_results').' '.$city }}</h2>
            <div id='zone-list'>
                <?php  $halls = $other_halls; ?>
                @include('halls.list')
            </div>
        </div>
        @endif
    </section>
</div>

<script>
    $(function(){
        $('#searchbyname').keyup(function() {
            
            var city = '<?php echo (isset($city)) ? $city : ''; ?>';            
            var search = $(this).val();  

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: "{{ url('/hall/searching') }}",
                data: {
                    'metier' : 'hall_owner',
                    'name' : search,  
                    'city' : city
                },
                success: function(data){
                    $('#results #zone-list').html(data);
                },
                error:function(jqXHR, textStatus){
                    console.log(jqXHR);            
                }
            });             
        });        
    });
</script>

@endsection