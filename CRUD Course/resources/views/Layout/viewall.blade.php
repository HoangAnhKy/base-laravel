<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env("APP_NAME") }}</title>
    <link rel="stylesheet" href="{{ asset("bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    @stack("css")
</head>
<body>
@include("Layout.notification")
@yield("content")
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset("bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.min.js") }}"></script>
@stack("js")
</html>
