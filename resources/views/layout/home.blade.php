<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content=""><!-- Description In Google-->
    <meta name="author" content=""> <!-- Name Mohamed Alaa-->
    <title>Regist Event</title><!-- Title In Tab Put Your Porject Name -->

    <link rel="icon" href="{{asset('assets/home/images/iconmolo.png')}}">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- Google Font  -->
    <!-- coming soon CSS -->
    <link href="{{asset('assets/home/css/stylecommingsoon.css')}}" rel="stylesheet">
    <!-- Main -->
    <link href="{{asset('assets/home/css/style.css?v=2')}}" rel="stylesheet">
    <!-- Responsive -->
    <link href="{{asset('assets/home/css/media-queries.css')}}" rel="stylesheet">
    <!-- Start Color Theme appSun -->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    @livewireStyles
</head>
<body class="loading-scroll-hiden">
<!-- Start Loading -->

{{$slot}}

@livewireScripts
<!-- JQuery.js -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- JQuery-ui.js -->
<!-- bootstrap.min.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@yield('js')
@stack('js')
</body>
</html>
