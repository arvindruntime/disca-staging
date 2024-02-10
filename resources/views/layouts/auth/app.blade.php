<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.auth.head')

        @yield('css')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <style>
            .error {
                color: red;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>