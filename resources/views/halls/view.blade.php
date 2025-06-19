@extends('layouts.app')

@section('content')
<div class='banner'>
  <div class="container">
      <ol class="breadcrumb-nav">
          <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/hall') }}">{{ __('halls') }}</a></li>
          <li class="breadcrumb-item active">{{ $hall->name }}</li>
      </ol>
      @include('search.form')
  </div>
</div>
<div class="container hall view">
  <header class='strip'> 
      <div class='interactions'>                        
        <div class='zone-like'>
            @if(Auth::check())
                @if($hall->isLiked(Auth::user()->id))
                   <div class='like liked' id='{{ $hall->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='hall'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $hall->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='hall' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>                            
                @else
                    <div class='like liked' id='{{ $hall->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='hall' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $hall->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='hall'>
                         <i class='fa fa-heart'></i>
                    </div>
                @endif                                        
            @else
                <div class='like'><i class='fa fa-heart'></i></div>
            @endif
            <div class='total'>{{ $hall->getLikes() }}</div>
        </div>
        <div class='zone-interest'>
            @if(Auth::check())
                @if($hall->isInterested(Auth::user()->id))
                    <div class='interest interested' id='{{ $hall->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='hall'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $hall->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='hall' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>                            
                @else
                    <div class='interest interested' id='{{ $hall->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='hall' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $hall->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='hall'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                @endif
            @else
                <div class='interest'><i class='fa fa-bookmark'></i></div>
            @endif
            <div class='total'>{{ $hall->getInterests() }}</div>
        </div>    
     </div>


      <div class='zone-description'>
          <h1>{{ $hall->name }}
            @if(!is_null($hall->getAverageScore()))
              <a href='#zone-advices' class='score'>
                @include('advices.entity')
                <span class='count'>{{ count($hall->getAdvices()) }} avis</span>
              </a>
            @endif
          </h1>
         
          <div>
            @if($hall->description != '')
              {{ $hall->description }}  
            @else
                {{ __('no_description') }}
            @endif
          </div>
     </div>


     <div id="button-modal-pro" class='message-button'>{{ __('send_message') }}</div>
  </header>
  
  <section>
    <aside>

      <div class='contact-person bloc strip'>
        <h4>{{ __('contact_person') }}</h4>
        <hr>
        <ul>
          <li><img class='avatar' src="{{ url('images/avatar/'.$professional->getSetting('avatar')) }}"></li>
          <li>{{ $professional->user->firstname.' '.$professional->user->name }}</li>
          <li>{{ $professional->email }}</li>
          <li>{{ $professional->tel }}</li>
        </ul>
      </div>

      <!--<div class='price strip'>
        <span class='price'>
          @if(isset($hall->getCurrentPrice()->price))
            {{ $hall->getCurrentPrice()->price }} €
          @else
          @endif
          </span>
      </div>-->
      <div class='informations bloc strip'>
        <h4>{{ __('informations') }}</h4>
        <hr>
        <ul>
          <li><?php echo ($address) ? $address->formatage() : 'Aucune adresse' ?></li>
          <li>{{ $hall->capacity }}</li>
          @if($hall->parking)
            <li>{{ __('parking') }}</li>
          @endif
          <li><?php echo (!is_null($professional->website)) ? '<a href="'.$professional->website.'">Site Web</a>' : 'Aucun site' ?></li>
        </ul>
       </div>     
    </aside>
    <section>
    @if(count($hall->images) > 0)
      <div class='images'>
        <h3>{{ __('gallery') }} <span>({{ count($hall->images) }})</span></h3>
        <a href="{{ url('hall/'.$hall->id.'/'.$hall->slug.'/gallery') }}">{{ __('gallery') }}</a>
        <ul id='lightslider'>
        @foreach($hall->images as $image)
        <li>
            <a href="{{  url('images/hall/'.$image->url) }}" data-lightbox="{{ $image->id }}">
              <img src="{{  url('images/hall/'.$image->url) }}" class='miniature' >
            </a>
        </li>
        @endforeach
      </ul>
      
      </div>
    @endif
     
      <div class='zone-map'>
        <h3>{{ __('map') }}</h3>
        @if(isset($address->latitude) && isset($address->longitude))
          <div id='map' data-x='{{ $address->latitude }}' data-y='{{ $address->longitude }}'></div>
        @endif        
      </div>
      <div id='zone-advices'>
      @if(!$userAdvice)
        @include('advices.form')
      @endif
        @include('advices.list')
      </div>
    </section>  
 </section>
</div>
@include('messages.modals.professional')

<script>
    window.onload = function(){

        var x = $('#map').data('x');
        var y = $('#map').data('y');
        

        var map = L.map('map').setView([x, y], 13);
        var tileStreet = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            center: [x, y],
            maxZoom: 15,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoic2FtaXJhbG9yY2hpIiwiYSI6ImNrMHdqMnhqMjAza3AzaW1tZzU2NHhmaTIifQ.G1Ycxbr7vaDqsoWz3aowyg'
        });
        tileStreet.addTo(map);

        var marker = L.marker([x, y]).addTo(map);

        marker.bindPopup("<?php echo $professional->surname ?>");
    }  



   
      $('#button-modal-pro').click(function() {
          $('#message-modal-pro').modal();
      });
  
       $(document).on('submit', '#message-pro-form', function(e) {  
            e.preventDefault();
              
            $('input+small').text('');
            $('input').parent().removeClass('has-error');
              
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                //dataType: "json"
            })
            .done(function(data) {
                console.log(data);
                $('.alert-success').removeClass('hidden');
                $('#message-modal-pro').modal('hide');
            })
            .fail(function(data) {
                console.log(data);
                $.each(data.responseJSON, function (key, value) {
                    var input = '#message-form input[name=' + key + ']';
                    $(input + '+small').text(value);
                    $(input).parent().addClass('has-error');
                });
            });
        }); 

        
</script>

@endsection

