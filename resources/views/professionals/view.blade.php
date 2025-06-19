@extends('layouts.app')

@section('content')
<div class='banner'>
  <div class="container">
      <ol class="breadcrumb-nav">
          <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/professional') }}">{{ __('professionals') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/metier/'.$professional->metiers[0]->id.'/'.$professional->metiers[0]->name) }}">{{ __($professional->metiers[0]->name) }}</a></li>
          <li class="breadcrumb-item active">{{ $professional->surname }}</li>
      </ol>
      @include('search.form')
  </div>
</div>
<div class="container professional view">
  <header class='strip'>      
      <div class='zone-avatar'>  
        <div class="avatar">
          <img src="{{ url('images/avatar/'.$professional->getSetting('avatar')) }}">
        </div>
      </div>

      <div class='interactions'>                        
        <div class='zone-like'>
            @if(Auth::check())
                @if($professional->isLiked(Auth::user()->id))
                    <div class='like liked' id='{{ $professional->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='professional'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $professional->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='professional' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>                            
                @else
                    <div class='like liked' id='{{ $professional->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='professional' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $professional->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='professional'>
                         <i class='fa fa-heart'></i>
                    </div>
                @endif                                        
            @else
                <div class='like'><i class='fa fa-heart'></i></div>
            @endif
            <div class='total'>{{ $professional->getLikes() }}</div>
        </div>
        <div class='zone-interest'>
            @if(Auth::check())
                @if($professional->isInterested(Auth::user()->id))
                    <div class='interest interested' id='{{ $professional->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='professional'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $professional->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='professional' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>                            
                @else
                    <div class='interest interested' id='{{ $professional->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='professional' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $professional->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='professional'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                @endif
            @else
                <div class='interest'><i class='fa fa-bookmark'></i></div>
            @endif
            <div class='total'>{{ $professional->getInterests() }}</div>
        </div>    
     </div>


      <div class='zone-description'>
          <h1>{{ $professional->surname }}
            @if(!is_null($professional->getAverageScore()))
              <a href='#zone-advices' class='score'>
                @include('advices.entity')
                <span class='count'>{{ count($professional->getAdvices()) }} avis</span>
              </a>
            @endif
          </h1>
          <div>{{ $professional->metiers[0]->name }}</div>
          <div>
            @foreach($professional->skills as $skill)
              <span><a href="{{ url('skill/'.$skill->id).'/'.$skill->name }}">#{{ $skill->name }}</a></span>
            @endforeach
          </div>
          <div>
            @if($professional->description != '')
              {{ $professional->description }}  
            @else
                {{ __('no_description') }}
            @endif
          </div>
     </div>
      @if (Auth::check())
        @if(Auth::user()->id != $professional->user->id)
          <div id="button-modal-pro" class='message-button'>{{ __('send_message') }}</div>
        @endif
      @endif
  </header>
  
  <section>
    <aside>
      <div class='price bloc strip'>
        <span class='price'>
          @if(isset($professional->getCurrentPrice()->price))
            {{ $professional->getCurrentPrice()->price }} €
          @else
          @endif
          </span>
      </div>
      <div class='informations bloc strip'>
        <div>{{ __('informations') }}</div>
        <hr>
        <ul>
          <li><?php echo ($address) ? $address->formatage() : 'Aucune adresse' ?></li>
          <li>{{ $professional->email }}</li>
          <li>{{ $professional->tel }}</li>
          <li><?php echo (!is_null($professional->website)) ? '<a href="'.$professional->website.'">Site Web</a>' : 'Aucun site' ?></li>
        </ul>
       </div>
       @if(count($networks) > 0)
         <div class='networks bloc strip'>
            <ul>
            @foreach($networks as $network =>$url)
              <li><a href="{{ $url }}">{{ $network }}</a></li>
            @endforeach
            </ul>
         </div>
       @endif
    </aside>
    <section>
     @if(count($professional->videos) > 0)
      <div class='videos'>
        @foreach($professional->videos as $video)
        <div class='video'>
          <iframe width="370" height="280" src="https://www.youtube.com/embed/{{ $video->url }}">
          </iframe>
        </div>
        @endforeach
      </div>
      <hr>
      @endif
      <div class='zone-map'>
        @if(isset($address->latitude) && isset($address->longitude))
          <div id='map' data-x='{{ $address->latitude }}' data-y='{{ $address->longitude }}' data-d='{{ $professional->getSetting("distance") }}'>
        @endif
        </div>
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
</div>
@include('messages.modals.professional')

<script>
    window.onload = function(){

        var x = $('#map').data('x');
        var y = $('#map').data('y');
        var d = $('#map').data('d');

        if(d > 100){
          zoom = 7;
        }
        else if(d > 50){
          zoom = 8;
        }
        else if(d > 15){
          zoom = 9;
        }
        else{
          zoom = 10;
        }

        var map = L.map('map').setView([x, y], zoom);
        var tileStreet = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            center: [x, y],
            maxZoom: 15,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoic2FtaXJhbG9yY2hpIiwiYSI6ImNrMHdqMnhqMjAza3AzaW1tZzU2NHhmaTIifQ.G1Ycxbr7vaDqsoWz3aowyg'
        });
        tileStreet.addTo(map);

        var marker = L.marker([x, y]).addTo(map);
        L.circle([x, y], {radius: d*1000}).addTo(map);

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

