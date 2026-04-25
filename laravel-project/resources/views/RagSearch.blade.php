@extends('layouts.base')

@section('title','RAG検索')

@section('content')
<div class="m-5">
    <div class="border p-4 col-7 m-auto">
        <div class="col-2 col-7 m-auto">
            <h2>RAG検索</h2>
            <form action="{{route('RAGSearch')}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea cols="30" rows="8" name="q" classmaxlength="100" class="form-control mb-3"></textarea>
                    <input type="submit"  class="btn btn-primary">
                </div>
            </form>

            @if(!empty($answer))
                <div class="border p-4 m-auto mt-2">
                    {{$answer}}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection