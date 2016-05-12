<!-- Stored in resources/views/layouts/master.blade.php -->

<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            <!--nav bar -->
            <div id="wrapper">
                <!-- Navigation -->
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="row">
                        <div class="col-xs-4">        
                            <div class="navbar-header">
                                <a class="navbar-brand" href="/">{{ isset($title) ? $title : "League Project" }}</a>
                            </div>
                            <!-- /.navbar-header -->
                        </div>
                        <div class="col-xs-4"> 
                            <div class="navbar-right">
                                Login Button Here
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!--nav bar-->
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>