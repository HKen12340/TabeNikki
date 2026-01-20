<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}" />
    <title>Document</title>
</head>
<body>
{{\Illuminate\Support\Facades\Auth::user()->name}}でログインしています。
    <form action="{{route('user.logout')}}" method="post">
        @csrf
        <button>ログアウト</button>
    </form>
    <a href={{route('showContentRegistForm')}} >登録フォーム</a>
    <div style="width:70%;margin:auto; ">
        <div style="display: flex;flex-wrap: wrap;">
        @foreach ($items as $item)
            <div style="min-width: 30%;border:1px black solid;padding:5px;margin:5px;">
                <img src={{ asset(optional($item->image)->food_img) }} alt="">
                <p>料理名：{{$item->food_name}}</p>
                <p>店名：{{$item->shop_name}}</p>
                <p>料金：{{$item->price}}</p>

                <a href={{route('detailContent',['id' => $item->id])}}>詳細</a>
            </div>
        @endforeach
        </div>
    </div>    
</body>
</html>