<!DOCTYPE html>
<html>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">

    <link href="{{asset('semantic/dist/semantic.min.css')}}" rel="stylesheet">

    @yield('css')
    <link href="{{asset('css/style.css')}}" rel="stylesheet">



</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">LOGO</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">

                @if(auth::guard('admin')->check())
                    {{--<li><a href="{{route('addbus.index')}}">Add Bus</a></li>--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">Bus Management <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('addbus.index')}}">Add Bus</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('route')}}">Route Management</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('add-schedule')}}">Schedule Management</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('adminseat')}}">Seat Layout</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Manage Reservation</a></li>
                    <li><a href="#">Support</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guard('admin'))


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

    <div class="clear-fix"></div>
</nav>

<div class="container">
    @yield('content')

</div>


<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
@yield('moment')
@yield('datetimepickerjs')
{{--  @yield('customjs')--}}
<script src="{{asset('js/customscript.js')}}"></script>
@yield('seat')
@yield('ajax')


</body>
</html>



