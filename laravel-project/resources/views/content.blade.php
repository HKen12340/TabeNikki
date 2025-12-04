<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach ($items as $item)
    <a href={{route('updateForm',['id' => $item->id])}} >更新</a>
        <h2>料理名：{{$item->food_name}}</h2>
        <img src={{ asset(optional($item->image)->food_img) }} alt="">
        <p>店名：{{$item->shop_name}}</p>
        <p>料金：{{$item->price}}</p>
        <p>場所：{{$item->place}}</p>
        <p>訪問日：{{$item->visit_date}}</p>
        <p>感想：{{$item->thoughts}}</p>

        お店の外観
        <img src={{ asset(optional($item->image)->shop_img) }} alt="">
    @endforeach
</body>
</html>
