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
    <link href="{{asset('assets/home/css/style.css')}}" rel="stylesheet">
    <!-- Responsive -->
    <link href="{{asset('assets/home/css/media-queries.css')}}" rel="stylesheet">
    <!-- Start Color Theme appSun -->



    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


</head>
<body class="loading-scroll-hiden">
<!-- Start Loading -->


<section class="coming-soon home-page text-center main-page" >
    <div class="safehosting-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="wow fadeInUp">Playlist Live Festival </h1>
                    <!-- Id Append Time -->
                    <div class="timer wow fadeInUp" data-wow-delay=".1s" id="commingsoon"></div>
                    <!-- End Id Append Time -->
                    <div class="wow fadeInUp contant-prag" data-wow-delay=".4s">
                        <h4 class="wow fadeInUp"><badge class="bg-danger radius-50"> 1000 </badge> &nbsp;  Tiket Tersedia </h4>
                    </div>
                    <div class="wow fadeInUp contant-btn" data-wow-delay=".8s">
                        <a href="{{route('login')}}" class="aboutUsbtn" id="more-about"> Sign In </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- JQuery.js -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- JQuery-ui.js -->

<!-- bootstrap.min.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    //Js Prue
    // Date Apdate Up To You .
    var countDownDate = new Date("Sep 5, 2022 15:37:25").getTime();
    // Update the count down every 1 second
    var x = setInterval(function () {
        'use strict';
        // Get todays date and time
        var now = new Date().getTime(),// Find the distance between now an the count down date
            distance = countDownDate - now,// Time calculations for days, hours, minutes and seconds
            days = Math.floor(distance / (1000 * 60 * 60 * 24)),
            hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
            minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
            seconds = Math.floor((distance % (1000 * 60)) / 1000),
            // Html For Comming Soon Append By Js
            html = '<div class="days-wrapper"><span class="days">' + days + '</span><br>days</div><span class="slash">/</span><div class="hours-wrapper"><span class="hours">' + hours + '</span> <br>hours</div><span class="slash">/</span><div class="minutes-wrapper"><span class="minutes">' + minutes + '</span> <br>minutes</div><span class="slash">/</span><div class="seconds-wrapper"><span class="seconds">' + seconds + '</span> <br>seconds</div>';

        // Output the result in an element with id="commingsoon"
        document.getElementById("commingsoon").innerHTML = html;
        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("commingsoon").innerHTML = "EXPIRED";
        }
    }, 0);
</script>
</body>
</html>
