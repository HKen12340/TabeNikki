@extends('layouts.base')

@section('title',"記録更新フォーム")

@section('content')
    <div class="m-3">
        <div class="border col-7 p-4 m-auto">
            <h2>更新フォーム</h2>

            {{--  エラーメッセージをすべて表示する  --}}
            @if ($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li><p style="color: red">{{$error}}</p></li>
                    @endforeach
                </ul>
            @endif
            <form action={{route('updateContent',['id' => $item->id])}} method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-grou mb-3">
                    <label>料理名:</label>
                    <input type="text" name="food_name" maxlength="100" class="form-control" value={{$item->food_name}} required>
                </div>
                <div class="form-grou mb-3">
                    <label>店名:</label>
                    <input type="text" name="shop_name" class="form-control" maxlength="100" value={{$item->shop_name}} required>
                </div>
                <div class="form-grou mb-3">
                    <label for="">料金:</label>
                    <input type="number" name="price" class="form-control" value={{$item->price}} required>
                </div>
                        
                <div class="form-grou mb-3">
                    <label for="">来店日:</label>
                    <input type="date" name="visit_date" class="form-control" value={{$item->visit_date}} required>
                </div>
                <div class="form-grou mb-3">
                    <label for="">場所:</label>
                    <input type="text" name="place" maxlength="100" class="form-control" value={{$item->place}} required>
                </div>
                <div class="form-grou mb-3">
                    <label for="">料理写真:</label>
                    <input type="file" class="form-control" name="food_img" >
                </div>
                <div class="form-grou mb-3">
                    <label for="">店舗写真:</label>
                    <input type="file" class="form-control" name="shop_img" >
                </div>
                <div class="form-grou mb-3">
                    <label for="">感想:</label>
                    <textarea name="thoughts"  maxlength="300" class="form-control" >{{$item->thoughts}}</textarea>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <td style="position:relative;width:25%;">
                            <p style="position:absolute;top:50%;width:100%;text-align:center;">更新前の料理写真</p>
                        </td>
                        <td>
                            <div style="text-align:center;">
                                <img src={{ asset(optional($item->image)->food_img) }} alt="" style="width: 50%;height:50%;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="position:relative;width:25%;">
                            <p style="position:absolute;top:50%;width:100%;text-align:center;">更新前のお店写真</p>
                        </td>
                        <td>
                            <div style="text-align:center;">
                                <img src={{ asset(optional($item->image)->shop_img) }} alt="" style="width: 50%;height:50%;">
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="submit"   class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection