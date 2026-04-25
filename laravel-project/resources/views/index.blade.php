@extends('layouts.base')

@section('title',"記録一覧")

@section('content')
      <div class="container">
              @foreach ($items as $item)
                  @if($loop->first)
                      <div class="" style="display: grid;
                      /* 1列目から順番に180px、1fr、160pxの幅 */
                      grid-template-columns: 1fr 1fr 1fr;">
                  @endif

                  @if($loop->index % 3 === 0)
                      </div>
                      <div class="" style="display: grid;
                      /* 1列目から順番に180px、1fr、160pxの幅 */
                      grid-template-columns: 1fr 1fr 1fr;gap:30px;">
                  @endif
                  <div class="card border col-3 m-3  p-0" style="width:100%;">
                      <img class="card-img-top" src={{ asset(optional($item->image)->food_img) }} style="width: 100%;height:280px" alt="">
                      <div class="card-body">
                          <h5 class="card-title">{{$item->food_name}}</h5>
                          <p class="card-text">店名：{{$item->shop_name}}</p>
                          <p class="card-text">料金：{{$item->price}}円</p>
                          <a  class="btn btn-primary" href={{route('detailContent',['id' => $item->id])}}>詳細</a>
                      </div>
                  </div>
                  @if($loop->last)
                          </div>
                  @endif
              @endforeach
              <div class="d-flex justify-content-center">
                {{$items->links()}}
              </div>
      </div>
 @endsection