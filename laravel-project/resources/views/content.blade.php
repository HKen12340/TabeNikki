@extends('layouts.base')

@section('title',"記録詳細")

@section('content')
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
@endsection
    