
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('/bootstrap/bootstrap.min.css') }}" />
        <title>Document</title>
    </head>
    
    <body>

    @component('components.header')
    @endcomponent

    <!-- モーダルを開くボタン・リンク -->
    <a class="btn btn-primary" data-toggle="modal" data-target="#testModal">削除</a>

    <!-- ボタン・リンククリック後に表示される画面の内容 -->
    <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>削除確認画面</h4>
                </div>
                <div class="modal-body">
                    <label>データを削除しますか？</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <form action="{{route('deleteContent',['id' => $item->id])}}" method="post" >
                        @csrf    
                        @method("delete")
                        <button  type="submit"   class="btn btn-danger">削除</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <a href={{route('updateForm',['id' => $item->id])}} >更新</a>
        
        <div class="" style="display:flex;justify-content:center">
            <img src={{ asset(optional($item->image)->food_img) }} class="col-4" alt="">
        </div>  
        <div class="col-4" style="margin:auto">
            <h2>{{$item->food_name}}</h2>
            <p>感想：{{$item->thoughts}}</p>
            <p>店名：{{$item->shop_name}}</p>
            <p>料金：{{$item->price}}</p>
            <p>場所：{{$item->place}}</p>
            <p>訪問日：{{$item->visit_date}}</p>
            お店の外観
            <img src={{ asset(optional($item->image)->shop_img) }} alt="">
         </div>
    </body>
        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>