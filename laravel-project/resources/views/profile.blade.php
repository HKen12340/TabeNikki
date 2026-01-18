<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>プロフィール</title>
    </head>
    <body>
        {{\Illuminate\Support\Facades\Auth::user()->name}}でログインしています。
        <form action="{{route('user.logout')}}" method="post">
            @csrf
            <button>ログアウト</button>
        </form>
    </body>
</html>
