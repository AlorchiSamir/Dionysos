<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{ $data['firstanme'].' '.$data['name'] }} vous a envoyé un message</h2>
    <p>Vous venez de recevoir un message</p>
    <a href="{{ url('/message') }}">Boîte de réception</a>
  </body>
</html>