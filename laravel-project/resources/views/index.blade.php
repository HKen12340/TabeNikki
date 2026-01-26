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
                      <img class="card-img-top" src={{ asset(optional($item->image)->food_img) }} alt="">
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
  </body>
</html>