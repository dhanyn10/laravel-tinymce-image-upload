@extends('layout')
@section('content')
    
<script>
    tinymce.init({ 
        selector:'#with-image-upload',
        menubar: false,
        plugins: 'image',
        automatic_uploads: false,
        images_upload_url: '/upload',
        toolbar: 'image bold italic underline'
    });
</script>
<a class="px-4 py-2 text-white rounded-sm bg-indigo-950 m-2" href="{{route('home')}}">back</a>
<form method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <textarea name="" id="with-image-upload"></textarea>
</form>
@endsection