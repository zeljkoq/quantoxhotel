<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--@if (auth()->check())--}}
        {{--<meta name="api-token" content="{{ auth()->user()->api_token }}">--}}
    {{--@endif--}}
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Scripts -->
    <script src="{{ asset('js/local.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top"">
            <div class="container">
                {{--<div id="routes"></div>--}}
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Quantox Hotel') }}
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul id="routes" class="nav navbar-nav">
                        {{--<li><a href="{{route('song.index')}}">Songs</a></li>--}}
                        {{--<li><a href="{{route('organization.index')}}">Party organization</a></li>--}}
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                            <li><a style="display: none;" id="nLogin" href="{{route('login')}}">Login</a></li>

                            <li class="dropdown">
                                <a id="nLoginDrop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('logout') }}">Logout</a></a></li>
                                </ul>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container">
            @yield('content')
        </div>
        <div id="messages" class="">

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="{{ asset('js/local.js') }}" defer></script>
     {{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
        $.ajaxSetup({
            headers: {
                "Authorization" : "Bearer " + localStorage.getItem('token'),
            },
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker4').datetimepicker();
        });
    </script>
    <script>
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: '{{route('get.routes')}}',
                headers: {
                    "Accept" : "application/json",
                    "Content-Type" : "application/json",
                },
                success: function (data) {
                    var html = '';
                    for (i=0; i<data.routes.length; i++)
                    {
                        html += '<li><a href="'+data.routes[i]+'">'+ucfirst(data.routes[i])+'</a></li>';
                    }
                    console.log(html);
                    $('#routes').html(html);
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route('login.me')}}',
                headers: {
                    "Accept" : "application/json",
                    "Content-Type" : "application/json",
                },
                success: function (response) {
                    if (response.name)
                    {
                        $('#nLogin').css('display', 'none');
                        $('#nLoginDrop').css('display', 'block');
                        $('#nLoginDrop').text(response.name);
                    }
                    else
                    {
                        $('#nLogin').css('display', 'block');
                        $('#nLoginDrop').css('display', 'none');
                        $('#nLoginDrop').text(response.name);
                    }
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
