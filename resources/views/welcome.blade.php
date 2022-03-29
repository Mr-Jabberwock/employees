<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Employees</title>
</head>
<body>
    <div class="container">
        <div id="app">
            <employees></employees>
        </div>
    </div>

    <script src="{{ asset('/js/app.js')}}"></script>
</body>
</html>