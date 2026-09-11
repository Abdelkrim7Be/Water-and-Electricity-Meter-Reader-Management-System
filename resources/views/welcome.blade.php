<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>La relève</title>

    @vite('resources/js/app.js')
    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>

</head>

<body>
    <div id="app">
        @if (Auth::check())
            <script>
                window.authUser = {{ Illuminate\Support\Js::from(Auth::user()->only(['id', 'fullName', 'userType'])) }};
                window.permissions = {{ Illuminate\Support\Js::from(Auth::user()->role?->permission) }};
            </script>
        @else
            <script>
                window.authUser = null;
            </script>
        @endif
    </div>
</body>



</html>
