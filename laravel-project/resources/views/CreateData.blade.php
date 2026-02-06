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
                                <label>food_name:</label>
                                <input type="text" class="form-control" name="food_name" maxlength="100" required>
                            </div>
                            <div class="form-grou mb-3">
                                <label>shop_name:</label>
                                <input type="text" class="form-control" name="shop_name" maxlength="100" required>
                            </div>
                            <div class="form-grou mb-3">
                                <label for="">price:</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            
                            <div class="form-grou mb-3">
                                <label for="">visit_date:</label>
                                <input type="date" class="form-control" name="visit_date" required>
                            </div>

                            <div class="form-grou mb-3">
                                <label for="">place:</label>
                                <input type="text" class="form-control" name="place" maxlength="100" required>
                            </div>

                            <div class="form-grou mb-3">
                                <label for="">food_img:</label>
                                <input type="file" class="form-control" name="food_img" >
                            </div>
                            <div class="form-grou mb-3">
                                <label for="">shop_img:</label>
                                <input type="file" class="form-control" name="shop_img" >
                            </div>
                            <div class="form-grou mb-3">
                                <label for="">thoughts:</label>
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

