@extends('layouts.app')

@section('content')
<div class="container books">
    <div class="row">
        <div id='area'>
            <div id='metiers'>
                @foreach($datas as $type => $metiers)
                    <h3>{{ $type }}</h3>
                    @foreach($metiers as $metier)
                    <div>
                        
                        <a href='{{ url("/step/2/".$metier->id) }}' class='metier-step2' data-url='{{ url("/metier/type/".$metier->id) }}'>{{ $metier->name }}</a>
                        
                    </div>
                    @endforeach
                @endforeach
            </div>
            <script type="text/javascript">
        
               /* $(function(){
                    
                    $('.metier-step2').click(function(){
                        id = $(this).attr('id');
                        url = $(this).data('url');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: url,
                            success: function(data){
                                $('#area').html(data);
                            }
                        });
                    });
                });*/

            </script>
        </div>
    </div>
</div>
@endsection