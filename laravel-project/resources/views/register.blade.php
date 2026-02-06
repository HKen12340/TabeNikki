@extends('layouts.NoHeader_base')

@section('title','ユーザー登録画面')

@section('content')
<body>
    <div class="m-3">
        <div class="border col-7 p-4 m-auto">
            <h1>登録画面</h1>
            <form action="register" method="post">
                @csrf
                <div class="form-grou mb-3">
                    <label for="name">名前</label>
                    <input type="text"class="form-control" name="name" id="name">
                </div>
                <div class="form-grou mb-3">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-grou mb-3">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <input type="submit"  class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection
