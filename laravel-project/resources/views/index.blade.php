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
    <div class="container">
            @foreach ($items as $item)
                @if($loop->first)
                    <div class="row">
                @endif

                @if($loop->index % 3 === 0)
                    </div>
                    <div class="row">
                @endif
                <div class="border col-4 m-3" style="max-width: 400px;">
                    
                    <img src={{ asset(optional($item->image)->food_img) }} alt="">
                    <p>料理名：{{$item->food_name}}</p>
                    <p>店名：{{$item->shop_name}}</p>
                    <p>料金：{{$item->price}}</p>

                    <a href={{route('detailContent',['id' => $item->id])}}>詳細</a>
                </div>
                @if($loop->last)
                        </div>
                @endif
            @endforeach
     </div>
    
</body>
</html>