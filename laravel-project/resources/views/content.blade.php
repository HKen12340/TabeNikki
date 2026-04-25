@extends('layouts.base')

@section('title',"記録詳細")

@section('content')
<div class="border p-4 col-7 m-auto mt-5 mb-5">
    <!-- モーダルを開くボタン・リンク -->
    <a class="btn btn-danger" data-toggle="modal" data-target="#testModal">削除</a>

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

    <a class="btn btn-primary" href={{route('updateForm',['id' => $item->id])}} >更新</a>
    <div style="margin:auto">
        
        <div class="" style="display:flex;justify-content:center;height:400px;">
            <div class="col-8">
                <h2>{{$item->food_name}}</h2>
                <img src={{ asset(optional($item->image)->food_img) }}  style="width: 100%;height:90%;" alt="">
            </div>
        </div>  
            <div class="col-8" style="margin:auto">
                <table class="table">
                    <tr><th>店名</th><td>{{$item->shop_name}}</td></tr>
                    <tr><th>料金</th><td>{{$item->price}}</td></tr>
                    <tr><th>場所</th><td>{{$item->place}}</td></tr>
                    <tr><th>訪問日</th><td>{{$item->visit_date}}</td></tr>
                    <tr><th>感想</th><td>{{$item->thoughts}}</td></tr>
                </table>
            </div>
            
        </div>
        <div class="" style="display:flex;justify-content:center">
            <img src={{ asset(optional($item->image)->shop_img) }} class="col-8" alt="">
        </div>
    </div>
@endsection
    