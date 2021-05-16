<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="CringeTweets - A place where users can share and vote on the cringiest tweets they find." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{asset('images/logo2.jpg')}}" />
    <meta property="og:url" content="https://www.cringetweets.com" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('iimages/favicon-16x16.png')}}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D315VWP84N"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-D315VWP84N');
        </script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>CringeTweets</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
                <nav id="sidebar" class="sticky-top">
                    <div class="p-4 pt-5">
                      <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/logo_bird_only.jpg);"></a>
                        <ul class="list-unstyled components mb-5">
                            {{-- <li class="active">
                                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                                <ul class="collapse list-unstyled" id="homeSubmenu">
                                <li>
                                    <a href="#">Home 1</a>
                                </li>
                                <li>
                                    <a href="#">Home 2</a>
                                </li>
                                <li>
                                    <a href="#">Home 3</a>
                                </li>
                                </ul>
                            </li> --}}


                            <li class="{{ (request()->segment(1) == null) ? 'active' : '' }}">
                                <a href="/">Home</a>
                            </li>
                            <li class="{{ (request()->segment(1) == 'about') ? 'active' : '' }}">
                                <a href="/about">About</a>
                            </li>
                            <li class="{{ (request()->segment(1) == 'change') ? 'active' : '' }}">
                                <a href="/change">Change Log</a>
                            </li>
                            <li class="fire">
                                <a href="/support" class="fire"><i class="fas fa-heart"></i> Support</a>
                        </ul>

                        <div class="footer">
                            <p>
                                Copyright &copy; <a href="https://twitter.com/ezbakespring">ezbakespring</a> All rights reserved.
                            </p>
                            <p>Special thanks to <a href="https://twitter.com/Woofingson">@woofingson</a> for all the help.</p>
                        </div>

                    </div>
                </nav>
            </div>

            <div class="col">
                <div id="content" class="p-4 p-md-5">
                    <div id="app">
                      <app></app>
                    </div>

                  </div>
            </div>
        </div>
    </div>



    <script src="{{ mix('js/app.js') }}"></script>
    <script>

        (function($) {

        "use strict";

        var fullHeight = function() {

            $('.js-fullheight').css('height', $(window).height());
            $(window).resize(function(){
                $('.js-fullheight').css('height', $(window).height());
            });

        };
        fullHeight();

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

        })(jQuery);

    </script>
</body>
</html>
