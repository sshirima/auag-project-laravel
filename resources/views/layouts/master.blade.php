<!doctype html>
<html lang="{{ config('app.locale') }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- pass through the CSRF (cross-site request forgery) token -->
    <meta name="csrf-token" content="<?php echo csrf_token() ?>" />

    <head >
        <title >@yield('title')</title>
        <!-- Bootstrap CDN -->
        <link href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- JQuery CDN -->
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <!-- Javascript for bootstrap files -->
        <link src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}" rel="stylesheet">
        <!-- Font awesome cdn -->
        <link rel="stylesheet" href="{{ URL::asset('fontawesome/css/font-awesome.min.css') }}">
        <link href="{{ URL::asset('css/tab.content.css') }}" rel="stylesheet">
        <!-- Shield UI CSS file -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/shieldui.all.min.css') }}"/>
        <!-- Shield UI Jquery library -->
        <script type="text/javascript" src="{{ URL::asset('js/shieldui-lite-all.min.js') }}"></script>
        <!-- Table-view js file -->
        <script type="text/javascript" src="{{ URL::asset('js/table-view.js') }}"></script>
        

    </head>
    <body >
        <div class="row" >
            @include('includes.header')
        </div>
        <div class="row " style="padding: 10px">
            @include('includes.actionbar')
        </div>
        <div class="row" style="padding: 10px">
            <div class="col-md-2">
                @include('includes.sidebar')
            </div>
            <div class="col-md-10">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            @yield('content-heading')
                        </ul>
                    </div>
                    <div class="panel-body">
                        @include('includes.content-body-fieldset-table')
                        @yield('content-body')
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            @include('includes.footer')
        </div>
    </body>

</html>
