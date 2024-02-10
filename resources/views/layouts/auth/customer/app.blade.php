<!DOCTYPE html>
<html lang="en">
    <head>
        @include('customer.includes.head')

        @yield('css')
    </head>
    <body>
        @include('customer.includes.navigation')
        @yield('content')
        @include('customer.includes.footer')
    </body>
</html>