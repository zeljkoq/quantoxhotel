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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
                <ul id="routes" class="nav navbar-nav"></ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li><a id="nLogin" href="#">Login</a></li>
                        <li><a id="nRegister" href="#">Register</a></li>

                        <li class="dropdown">
                            <a id="nLoginDrop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <ul class="dropdown-menu">
                                    <li><a href="#" id="logout">Logout</a></li>
                                </ul>
                            </a>
                        </li>
                    </ul>
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

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script>
    $.ajaxSetup({
        headers: {
            "Authorization": "Bearer " + localStorage.getItem('token'),
        },
    });
</script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script type="text/javascript">
    $('#nLogin').click(function () {
        $('#mLogin').modal('show');
    });
    $('#nRegister').click(function () {
        $('#mRegister').modal('show');
    })

    $(function () {
        $('#partyDate').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',
        });
    });

</script>
<script>
    $('#logout').click(function () {
        localStorage.removeItem('token');
        localStorage.removeItem('routes');
        window.location = "{{route('home.index')}}";
    });

    var router = {
        routes: {
            'dj': [
                {
                    name: 'Songs',
                    link: 'songs'
                },
            ],
            'party': [
                {
                    name: 'Party',
                    link: 'party'
                }
            ],
            'regular': [
                {
                    name: 'Profile',
                    link: 'profile'
                }
            ]
        },
        showRoutes: function (roles) {
            roles.forEach(function (t) {
                router.showRoute(t);

            })
        },
        showRoute: function (role) {
            if (!router.routes[role]) {
                return;
            }
            router.routes[role].forEach(function (t) {
                $('#routes').append('<li><a href="'+t.link+'">'+ucfirst(t.name)+'</a></li>');
            });
        }
    };
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: '{{route('login.me')}}',
            headers: {
                "Accept": "application/json",
            },
            success: function (response) {
                if (typeof response.user !== 'undefined')
                {
                    if (response.user.id !== false) {
                        var rls = localStorage.getItem('routes');
                        $('#nLogin').css('display', 'none');
                        $('#nRegister').css('display', 'none');
                        $('#nLoginDrop').css('display', 'block');
                        $('#nLoginDrop').text(response.user.name);
                        router.showRoutes(rls.split(" "));
                    }
                }
                else {
                    localStorage.removeItem('token');
                    localStorage.removeItem('routes');
                }
            }
        });


        $.ajax({
            type: "POST",
            url: '{{route('get.regular.party.user')}}',
            headers: {
                "Accept": "application/json",
            },
            success: function (response) {
                console.log(response);
                if (typeof response.user !== 'undefined')
                {
                    if (response.user.id !== false) {

                    }
                }
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
