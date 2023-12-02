@extends('layout')
@section('content')
    
<script>
    const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/upload');

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            const json = JSON.parse(xhr.responseText);
            if (xhr.status === 403) {
                reject({ message: 'Error: ' + xhr.status, remove: true });
                return;
            }
            if (xhr.status === 400) {
                reject({ message: 'Error: ' + json.errorMessage, remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
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
        // statusbar: false,
        // plugins: 'tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
        // toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        plugins: 'image',
        automatic_uploads: false,
        images_upload_handler: example_image_upload_handler,
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