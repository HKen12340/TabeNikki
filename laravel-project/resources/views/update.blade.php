<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}" />
    <title>Document</title>
</head>
<body>
<div class="m-3">
    <h2>更新フォーム</h2>

    {{--  エラーメッセージをすべて表示する  --}}
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li><p style="color: red">{{$error}}</p></li>
            @endforeach
        </ul>
    @endif
<div class="border col-7 p-4">
    <form action={{route('updateContent',['id' => $item->id])}} method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grou mb-3">
            <input type="text" name="food_name" maxlength="100" class="form-control" value={{$item->food_name}} required>
        </div>
        <div class="form-grou mb-3">
            <img src={{ asset(optional($item->image)->food_img) }} alt="">
        </div>
        <div class="form-grou mb-3">
            <input type="text" name="shop_name" class="form-control" maxlength="100" value={{$item->shop_name}} required>
        </div>
        <div class="form-grou mb-3">
            <input type="number" name="price" class="form-control" value={{$item->price}} required>
        </div>
                
        <div class="form-grou mb-3">
            <input type="date" name="visit_date" class="form-control" value={{$item->visit_date}} required>
        </div>
        <div class="form-grou mb-3">
            <input type="text" name="place" maxlength="100" class="form-control" value={{$item->place}} required>
        </div>
        <div class="form-grou mb-3">
            <input type="file" class="form-control" name="food_img" >
        </div>
        <div class="form-grou mb-3">
            <input type="file" class="form-control" name="shop_img" >
        </div>
        <div class="form-grou mb-3">
            <textarea name="thoughts"  maxlength="300" class="form-control" value={{$item->thoughts}}></textarea>
        </div>
        <div class="form-grou mb-3">
            お店の外観
            <img src={{ asset(optional($item->image)->shop_img) }} alt="">
        </div>
        <input type="submit"   class="btn btn-primary">
    </form>
</div>
</div>
</body>
</html>
