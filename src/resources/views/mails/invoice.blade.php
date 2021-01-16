<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('main.app-name') }}</title>
</head>
<body>
    <h1>New Invoice Created by <span color='#09c'>{{ Auth::user()->name }}</span></h1>
    <div>
        click <a href="{{ route('invoice.show',$invoice->id) }}"> HERE</a> to see this invoice
    </div>
</body>
</html>
