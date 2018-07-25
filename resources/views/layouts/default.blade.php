<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes._meta')
        @include('includes._css')
    </head>
    <body>

        @include('includes.menu')

        <div class="container">

            @if($user)
                {!! Breadcrumbs::render(Route::currentRouteName(), @$breadcrumb) !!}
            @endif

            @yield('content')

            @include('includes.footer')

            @include('includes._js')

            @yield('js')

        </div>
    </body>
</html>
