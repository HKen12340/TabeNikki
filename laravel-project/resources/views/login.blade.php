<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}" />
    <title>Document</title>
</head>
<body>
    <div class="m-3">
        <h1>ログイン</h1>
        <div class="border col-7 p-4">
            <!-- フラッシュエラーメッセージ -->
            @if ($errors->has('msg'))
                <p>{{$errors->first('msg')}}</p>
            @endif
            <a href={{route("userRegistForm")}}>ユーザ登録</a>
            <form action="/" method="post">
                @csrf
                <div class="form-grou mb-3">
                    <label for="name">名前：</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-grou mb-3">
                    <label for="password">パスワード：</label>
                    <input type="password"  class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>
</body>
</html>
