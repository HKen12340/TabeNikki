@extends("layouts.base")

@section("content")
ランダム料理通知のテストを行うことができます。
送信ボタンを押すと登録されているからランダムで料理を選び、
登録メールアドレスへ選ばれた料理の情報が載ったメールを送信します。

<form action={{route('testmail')}} method="post" >
    @csrf
    <input type="submit" class="btn btn-primary" value="テスト">
</form>

@if(!empty($msg ?? ""))
    {{$msg}}
@endif

@endsection
