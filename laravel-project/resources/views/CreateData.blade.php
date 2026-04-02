@extends("layouts.base")

@section('title',"記録登録フォーム")

@section('content')
<div class="container">
    <div class="m-3">
        <div class="border col-7 p-4 m-auto">
            <h2>登録フォーム</h2>

            {{--  エラーメッセージをすべて表示する  --}}
            @if ($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li><p style="color: red">{{$error}}</p></li>
                    @endforeach
                </ul>
            @endif
            <div class="row">
                <div class="col-md p-4">
                        <form action={{route('ContentRegist')}} method="POST" enctype="multipart/form-data">
                            @csrf
                        
                            <div class="form-grou mb-3">
                                <label>料理名:</label>
                                <input type="text" class="form-control" name="food_name" maxlength="100" required>
                            </div>
                            <div class="form-grou mb-3">
                                <label>店名:</label>
                                <input type="text" class="form-control" name="shop_name" maxlength="100" required>
                            </div>
                            <div class="form-grou mb-3">
                                <label for="">料金:</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            
                            <div class="form-grou mb-3">
                                <label for="">来店日:</label>
                                <input type="date" class="form-control" name="visit_date" required>
                            </div>

                            <div class="form-grou mb-3">
                                <label for="">場所:</label>
                                <input type="text" class="form-control" name="place" maxlength="100" required>
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
                                <textarea name="thoughts" maxlength="300" class="form-control"></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary">
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

