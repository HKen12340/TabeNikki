@extends('layouts.NoHeader_base')

@section('title','ログイン画面')

@section('content')
    <div class="m-3">
        <div class="border col-7 p-4 m-auto align-items-center">
            <h1>ログイン</h1>
            <!-- フラッシュエラーメッセージ -->
            @if ($errors->has('msg'))
                <p>{{$errors->first('msg')}}</p>
            @endif
            <a href={{route("userRegistForm")}}>ユーザ登録</a>
            <form action="/" method="post">
                @csrf
                <div class="form-grou mb-3">
                    <label for="name">メールアドレス：</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-grou mb-3">
                    <label for="password">パスワード：</label>
                    <input type="password"  class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>
@endsection