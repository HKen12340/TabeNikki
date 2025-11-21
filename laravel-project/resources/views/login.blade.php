<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ログイン</h1>
    <form action="/" method="post">
        @csrf
        <label for="name">名前：</label><input type="email" name="email">
        <label for="password">パスワード：</label><input type="password" name="password">
        <button type="submit">送信</button>
    </form>
</body>
</html>
