<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>CringeTweets</title>
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
              <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/logo.jpg);"></a>
        <ul class="list-unstyled components mb-5">
          <li class="active">
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
          </li>
          <li>
              <a href="/about">About</a>
          </li>
          <li>
          <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
          <ul class="collapse list-unstyled" id="pageSubmenu">
            <li>
                <a href="#">Page 1</a>
            </li>
            <li>
                <a href="#">Page 2</a>
            </li>
            <li>
                <a href="#">Page 3</a>
            </li>
          </ul>
          </li>
          <li>
          <a href="#">Portfolio</a>
          </li>
          <li>
          <a href="#">Contact</a>
          </li>
        </ul>

        <div class="footer">
            <p>
                Copyright &copy; <a href="https://twitter.com/ezbakespring">ezbakespring</a> All rights reserved |
            </p>
        </div>

      </div>
    </nav>

    <!-- Page Content  -->
  <div id="content" class="p-4 p-md-5">
      <div id="app">
        <app></app>
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

        $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        });

        })(jQuery);

    </script>
</body>
</html>
