<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{config('app.name')}}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.tiny.cloud/1/{{config('tinymce')}}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        @yield('content')
    </body>
</html>