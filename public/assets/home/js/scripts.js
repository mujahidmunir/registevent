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


