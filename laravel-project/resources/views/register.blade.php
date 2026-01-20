<!doctype hmll>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録画面</title>
</head>
<body>
    <div class="m-3">
        <h1>登録画面</h1>
        <div class="border col-7 p-4">
        
            <form action="register" method="post">
                @csrf
                <div class="form-grou mb-3">
                    <label for="name">名前</label>
                    <input type="text"class="form-control" name="name" id="name">
                </div>
                <div class="form-grou mb-3">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-grou mb-3">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <input type="submit"  class="btn btn-primary">
            </form>
        </div>
    </div>
</body>
</html>

