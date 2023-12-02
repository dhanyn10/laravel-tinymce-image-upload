@extends('layout')
@section('content')
<div class="container m-4">
</div>
    <a class="px-4 py-2 text-white rounded-sm bg-green-500 m-2" href="{{route('image-disk')}}">image disk</a>
    <a class="px-4 py-2 text-white rounded-sm bg-sky-700 m-2" href="{{route('image-blob')}}">image blob</a>
@endsection