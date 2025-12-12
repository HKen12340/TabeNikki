<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>更新フォーム</h2>

    {{--  エラーメッセージをすべて表示する  --}}
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li><p style="color: red">{{$error}}</p></li>
            @endforeach
        </ul>
    @endif

    {{--  @foreach ($items as $item)  --}}
    <form action={{route('updateContent',['id' => $item->id])}} method="POST" enctype="multipart/form-data">
        @csrf
        <table>
                <tr>
                    <td><input type="text" name="food_name" maxlength="100" value={{$item->food_name}} required></td>
                    <img src={{ asset(optional($item->image)->food_img) }} alt="">
                    <td><input type="text" name="shop_name" maxlength="100" value={{$item->shop_name}} required></td>
                    <td><input type="number" name="price" value={{$item->price}} required></td>
                </tr>
                <tr>
                    <td><input type="date" name="visit_date" value={{$item->visit_date}} required></td>
                    <td><input type="text" name="place" maxlength="100" value={{$item->place}} required></td>
                    <td><input type="file" name="food_img" ></td>
                    <td><input type="file" name="shop_img" ></td>
                </tr>
                <tr>
                    <td><textarea name="thoughts"  maxlength="300" value={{$item->thoughts}}></textarea></td>
                </tr>
                <tr>
                    <td><input type="submit"></td>
                </tr>
        </table>
        お店の外観
        <img src={{ asset(optional($item->image)->shop_img) }} alt="">
    </form>
    {{--  @endforeach  --}}
</body>
</html>
