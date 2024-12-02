/*====================================
=            DOM IS READY            =
====================================*/
$(function() {


    if ($(this).scrollTop() > 0) {
        $('.header').addClass('sticky');
    } else {
        $('.header').removeClass('sticky');
    }




    // AOS
    AOS.init({
        once: true,
        // duration: 1000,
    });




    // Function to apply dark mode based on local storage
    function applyDarkMode() {
        if (localStorage.getItem('darkMode') === 'true') {
            $('.toggle-dark').addClass('dark');
            $('main').addClass('dark');
        } else {
            $('.toggle-dark').removeClass('dark');
            $('main').removeClass('dark');
        }
    }

    // Apply dark mode on page load
    applyDarkMode();

    $('.toggle-dark').on('click', function() {
        $(this).toggleClass('dark');
        $('main').toggleClass('dark');
        // Save dark mode state to local storage
        localStorage.setItem('darkMode', $(this).hasClass('dark'));
    });

    $('.big-nav .item a').on('click', function() {
        $('.toggle-nav').click();
    });

    $('.toggle-nav').on('click', function() {

        $(this).toggleClass('active');
        $('.header').toggleClass('active');
        $('.big-nav').toggleClass('active');


        // wait 300ms then add show to each item
        if ($(this).hasClass('active')) {
            setTimeout(function() {
                $('.big-nav .item').addClass('show');
            }, 50);
        } else {
            $('.big-nav .item').removeClass('show');

            
        }

    });







    // Speaker Popup
    $('.speaker.has-popup').on('click', function() {
        var popup = $(this).data('popup-target');
        $('#'+popup).addClass('active');

        // wait 300ms then add show to each item
        setTimeout(function() {
            $('#'+popup +' .columns').addClass('show');
        }, 100);
    });

    $('.close-speaker-popup').on('click', function() {
        $('.speaker-popup').removeClass('active');

        // remove show from each item
        $('.speaker-popup .columns').removeClass('show');
    });







    // Toggle Multi-Day
    $('.toggle-multi-day').on('click', function() {
        $(this).toggleClass('active');
        // $('.multi-day').toggleClass('active');
    });

    $('.toggle-track').on('click', function() {
        // remove all actives
        $('.toggle-track').removeClass('active');

        $(this).toggleClass('active');


        // add not active to all sessions
        // $('.session').addClass('not-active');

        // get the current name
        var trackName = $(this).data('track')

        // loop all sessions, if data-track not contiained add not-active
        $('.session').each(function() {

            var $session = $(this);
            
    
            if (!$session.data('tracks').includes(trackName)) {
                $session.addClass('not-active');
            } else {
                $session.addClass('about-to-fade-me-in')
                $session.removeClass('not-active');
        
                // Wait 100ms then show
                setTimeout(function() {
                    $session.removeClass('about-to-fade-me-in');
                }, 1);
            }
        });


        // add is-filtered to sessions-and-tracks
        $('.sessions-and-tracks').addClass('is-filtered');

    });

    $('.toggle-reset').on('click', function() {
        $(this).toggleClass('active');

        // wwait 300ms then remove
        setTimeout(function() {
            $(this).removeClass('active');
        }, 300);

        // remove is-filtered from sessions-and-tracks
        $('.sessions-and-tracks').removeClass('is-filtered');

        // remove not-active from all sessions
        $('.session').removeClass('not-active');

        // add active to all tracks
        $('.toggle-track').addClass('active');
    });







    $('.faqs .question').on('click', function() {
        $(this).closest('.item').toggleClass('active');
    });



    

})




/*========================================
=            WINDOW IS LOADED            =
========================================*/
$(window).on('load', function() {

    // Loaded


})



/*=========================================
=            WINDOW IS RESIZED            =
=========================================*/
// $(window).resize(function() {

// })




/*=========================================
=            WINDOW IS SCROLLED           =
=========================================*/
$(window).scroll(function() {

    if ($(this).scrollTop() > 0) {
        $('.header').addClass('sticky');
    } else {
        $('.header').removeClass('sticky');
    }

})