@extends('layout')
@section('content')
    

<script>
    const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/upload-disk');

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            const json = JSON.parse(xhr.responseText);
            if (xhr.status === 403) {
                reject({ message: 'Error: ' + xhr.status, remove: true });
                return;
            } else if (xhr.status === 400) {
                reject({ message: 'Error: ' + json.errorMessage, remove: true });
                return;
            } else if (xhr.status < 200 || xhr.status >= 300) {
                reject('Error: ' + xhr.status);
                return;
            }
            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }

            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
        
    });
    tinymce.init({ 
        selector:'#with-image-upload',
        menubar: false,
        plugins: 'image',
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: example_image_upload_handler,
        images_upload_url: '/upload-disk',
        toolbar: 'image bold italic underline'
    });
</script>
<a class="px-4 py-2 text-white rounded-sm bg-indigo-950 m-2" href="{{route('home')}}">back</a>
<form method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <textarea name="" id="with-image-upload"></textarea>
</form>
@endsection