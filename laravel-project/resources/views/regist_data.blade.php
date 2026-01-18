<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>登録フォーム</h2>

    {{--  エラーメッセージをすべて表示する  --}}
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li><p style="color: red">{{$error}}</p></li>
            @endforeach
        </ul>
    @endif

    <form action={{route('ContentRegist')}} method="POST" enctype="multipart/form-data">
        @csrf
        <table>
                <tr>
                    <td><input type="text" name="food_name" maxlength="100" required></td>
                    <td><input type="text" name="shop_name" maxlength="100" required></td>
                    <td><input type="number" name="price" required></td>
                </tr>
                <tr>
                    <td><input type="date" name="visit_date" required></td>
                    <td><input type="text" name="place" maxlength="100" required></td>
                    <td><input type="file" name="food_img" ></td>
                    <td><input type="file" name="shop_img" ></td>
                </tr>
                <tr>
                    <td><textarea name="thoughts" maxlength="300"></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit"></td>
                </tr>
        </table>
    </form>
</body>
</html>
