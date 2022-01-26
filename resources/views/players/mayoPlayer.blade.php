<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Unofficial {{$current_member -> display}}DB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/body.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="{{$current_member -> FontFamily}}" rel="stylesheet">
  <style>
    h2{
      text-shadow:1px 0 0 #FFF0F3,0 1px 0 #FFF0F3,-1px 0 0 #FFF0F3,0 -1px 0 #FFF0F3,3px 3px 0 #FFF0F3;
    }
  </style>
</head>
<body style="background-color: {{$current_member -> MainCol}};font-family: {{$current_member -> Font}};">
<header class="w-100 shadow">
    <div class="w-80 m-auto">
        <nav class="navbar p-3 p-md-5" style="background-color: {{$current_member -> NavCol}}">
            <h2 style="color: {{$current_member -> TitleCol}};font-family: {{$current_member -> TitleFont}}; ">Unofficial {{$current_member -> display}}DB</h2>
    </div>
</header>
<main>
  <div class="wrap">
    <div class="{{$name}}"></div>
  </div>
  <div id="app">
    <div class="container">
          <router-view  :categories="{{$categories}}":current_member="{{$current_member}}" :members="{{$members}}"></router-view> 
    </div>
    <div id="footer" class="fixed-bottom border-top border-3 pb-2" style="height:auto; background-color: {{$current_member -> MainCol}}; border-color: {{$current_member -> BtnCol}} !important;">
      <buttongroup :members="{{$members}}"></buttongroup>
    </div>
  </div>
  <div class="text-center" style="height: 100vh; width: 100vw; padding-top: 50vh;">
    <p style="color:#E9546B;">※背景画像堪能用スペース</p>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}"></script> 
</body>
</html>