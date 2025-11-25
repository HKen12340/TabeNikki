<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>登録フォーム</h2>
    <form action={{route('ContentRegist')}} method="POST" enctype="multipart/form-data">
        @csrf
        <table>
                <tr>
                    <td><input type="text" name="food_name" max="100" required></td>
                    <td><input type="text" name="shop_name" max="100" required></td>
                    <td><input type="number" name="price" required></td>
                </tr>
                <tr>
                    <td><input type="date" name="visit_date" required></td>
                    <td><input type="text" name="place" max="100" required></td>
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
