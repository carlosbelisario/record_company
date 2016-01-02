<!DOCTYPE html>
<html ng-app="myApp">
    <head>
        <meta charset="utf-8">
        <title>App Name - @yield('title')</title>
        @section('stylesheet')
            <link href="{{ URL::asset('assets/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        @show
        @section('header_javascript')
            <script type="text/javascript" src="{{ URL::asset('assets/node_modules/angular/angular.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/node_modules/angular-route/angular-route.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/node_modules/angular-ui-bootstrap/ui-bootstrap-tpls.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/node_modules/angular-messages/angular-messages.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/node_modules/angular-resource/angular-resource.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/js/app.js') }}"></script>
            <script type="text/javascript" src="{{ URL::asset('assets/js/laroute.js') }}"></script>
        @show
    </head>
    <body>
        @section('header')
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="{{ URL::route('index') }}">Discografía</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#/album">Album <span class="sr-only">(current)</span></a></li>
                    <li><a href="#/artistas">Artistas</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        @show

        <div class="container">
            @yield('content')
        </div>
        @section('footer')
            <div class="page-footer" style="text-align: center">
                &copy; 2016 Compañia Discográfica todos los derechos reservados
            </div>
        @show
    </body>
</html>