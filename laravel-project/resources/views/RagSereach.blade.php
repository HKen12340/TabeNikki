@extends('layouts.base')

@section('title','RAG検索')

@section('content')
<h2>RAG検索</h2>
<form action="{{route('RAGSearch')}}" method="POST">
    @csrf
    <textarea cols="60" rows="8" name="q"></textarea>
    <input type="submit" />
</form>
@endsection