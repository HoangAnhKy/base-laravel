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
    <style>
        .list-group-custom {
            list-style-type: none;
            padding-left: 0;
        }

        .list-group-item-custom {
            padding: 10px;
        }

        .list-group-item-custom:hover {
            background: #343a40;
        }

    </style>
    @stack("css")
</head>
<body class="vh-100">
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-12 col-md-3 bg-dark text-white sticky-top h-100">
            @include("Layout.menu")
        </div>

        <div class="col-12 col-md-9 overflow-auto h-100">
            <div class="m-3">
                <h1>dev test</h1>
                @include("Layout.notification")
                @yield("content")
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<script src="{{ asset("bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.min.js") }}"></script>
<script>
    $(document).ready(function () {
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                error.insertAfter(element);
            },
        });
    })
</script>
@stack("js")
</html>
