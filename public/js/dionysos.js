$(function(){

  $('.image-delete').click(function(){
    id = $(this).data('id');
    ConfirmDialog('Are you sure');
    $(this).parent().hide();

    /*$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: "{{ url('/images/delete') }}",
        data: {
            'id': id,
        },
        success: function(data){
            $(this).parent().hide();
        }
    });*/
  });

  function ConfirmDialog(message) {
    $('<div></div>').appendTo('body')
      .html('<div><h6>' + message + '?</h6></div>')
      .dialog({
        modal: true,
        title: 'Delete message',
        zIndex: 10000,
        autoOpen: true,
        width: 'auto',
        resizable: false,
        buttons: {
          Yes: function() {
            // $(obj).removeAttr('onclick');                                
            // $(obj).parents('.Parent').remove();

            $('body').append('<h1>Confirm Dialog Result: <i>Yes</i></h1>');

            $(this).dialog("close");
          },
          No: function() {
            $('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');

            $(this).dialog("close");
          }
        },
        close: function(event, ui) {
          $(this).remove();
        }
      });
  };

  /*$('.message-info').fadeOut(5000);*/

  $("#lightslider").lightSlider({
    controls: true,
    item : 3
  });

  lightbox.option({

  });



  $('.search').on('keypress', function (e) {
         if(e.which === 13){
            var content = $(this).val();
            var url = $(this).data('url');
            window.location = url + '/' + content;
         }
   });

  $("a[href*='#']:not([href='#'])").click(function() {
      if (
          location.hostname == this.hostname
          && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
      ) {
          var anchor = $(this.hash);
          anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) +"]");
          if ( anchor.length ) {
              $("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
          }
      }
    });

  $('div.noliked').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object = $(this).data('object');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'like'
          },
          error:function(jqXHR, textStatus){
              console.log(jqXHR);            
            }
        });
        var score = parseInt($(this).parent().children('.total').text());
        $(this).parent().children('.total').text(score+1);
        $(this).parent().children('.liked').show();
      $(this).hide();
  });

  $('div.liked').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object = $(this).data('object');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'dislike'
          },
          error:function(jqXHR, textStatus){
              console.log(jqXHR);            
            }
        });
        var score = parseInt($(this).parent().children('.total').text());
        $(this).parent().children('.total').text(score-1);
        $(this).parent().children('.noliked').show();
      $(this).hide();
  });

  $('div.nointerested').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object =  $(this).data('object');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'interest'
          },
          error:function(jqXHR, textStatus){
              console.log(jqXHR);            
            }
        });
        var score = parseInt($(this).parent().children('.total').text());
        $(this).parent().children('.total').text(score+1);
        $(this).parent().children('.interested').show();
      $(this).hide();
  });

  $('div.interested').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object =  $(this).data('object');
      
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'disinterest'
          },
          error:function(jqXHR, textStatus){
            console.log(jqXHR);            
          }
        });
        var score = parseInt($(this).parent().children('.total').text());
        $(this).parent().children('.total').text(score-1);
        $(this).parent().children('.nointerested').show();
      $(this).hide();
  });

  $('div.up').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object =  $(this).data('object');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'vote',
              'value': '1'
            }
        });
        var up = parseInt($(this).parent().children().children('.upc').text());
        var down = parseInt($(this).parent().children().children('.downc').text());

        if($(this).hasClass('active')){
          $(this).removeClass('active');
          $(this).parent().children().children('.upc').text(up-1);
        }
        else{
          $(this).addClass('active');
          $(this).parent().children().children('.upc').text(up+1);
          if($('.down').hasClass('active')){
             $('.down').removeClass('active');
             $(this).parent().children().children('.downc').text(down-1);
          }
        }
  });

  $('div.down').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');
      object =  $(this).data('object');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'object_id': id,
              'object_type' : object,
              'type': 'vote',
              'value': '-1'
            },
            error:function(jqXHR, textStatus){
              console.log(jqXHR);            
            }
        });
        var up = parseInt($(this).parent().children().children('.upc').text());
        var down = parseInt($(this).parent().children().children('.downc').text());

        if($(this).hasClass('active')){
          $(this).removeClass('active');          
          $(this).parent().children().children('.downc').text(down-1);
        }
        else{
          $(this).addClass('active');
          $(this).parent().children().children('.downc').text(down+1);
          if($('.up').hasClass('active')){
             $('.up').removeClass('active');
             $(this).parent().children().children('.upc').text(up-1);
          }
        }
  });


  $('div.report').click(function(){
      id = $(this).attr('id');
      url = $(this).data('url');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            method: 'POST',
            url: url,
            data: {
              'advice_id': id
            }
        });
        $(this).addClass('reported');
        $(this).removeClass('report');
  });

  


  

});