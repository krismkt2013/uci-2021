/**
 *
 * @package Sticky Topbar
 * @author RainaStudio
 * @version 2.0.0
 */

(function( $ ) {

    // Dynamically Height and Margin Change
    function siteheaderHeight() {
        var theight = $(".topbar").outerHeight();
        $(".site-header").css("margin-top", theight );
        
    };
    siteheaderHeight();
    $(window).resize(function() {
        if ( $( ".topbar" ).length > 0 ) {
            siteheaderHeight();
        }
    });
    
    // Close Topbar
    $( "#on_off" ).click(function() {
        $( ".topbar" ).fadeOut( "slow", function() {
          // Animation complete.
        });
        $( ".topbar + .site-header" ).animate({ marginTop: '0px' }, 1000);
        Cookies.set('hideCookie', '1', { expires: 1, path: '/' });
    });
    // Perform cookie
    $(function () {
        if ( Cookies.set('hideCookie') ) {
            $('.topbar').remove();
            $( ".topbar + .site-header" ).css("margin-top", "0px");
        }
    });
    // Remove extra margin top of site header
    $(function() {
        if( $(".topbar").length == 0 ){
            $(".site-header").css("margin-top", "0");
        }
    });

    // Countdown
    $(function(){
        var printdate = $(".stick_cdate").text();
        var countDownDate = new Date( printdate ).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();
            
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
            
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
        // Output the result in an element with id="DateCountdown"
        $("#DateCountdown .pr .days").text( days );
        $("#DateCountdown .pr .hrs").text( hours );
        $("#DateCountdown .pr .min").text( minutes );
        $("#DateCountdown .pr .sec").text( seconds );
        
        /*= "<div class='pr days'><span class='days'>" + days + "</span><small>Days</small></div><div class='pr hrs'><span class='hrs'>"+ hours +"</span><small>Hours</small></div><div class='pr min'><span class='min'>"+ minutes +"</span><small>Minutes</small></div><div class='pr sec'><span class='sec'>"+ seconds +"</span><small>Seconds</small></div>";*/
            
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("DateCountdown").innerHTML = "EXPIRED";
        }
        }, 1000);
    });
    
    
})( jQuery );