<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <script src="https://cdn.tiny.cloud/1/{{config('tinymce')}}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        <script>
            const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/upload');
        
                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };
        
                xhr.onload = () => {
                    if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                    }
        
                    if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                    }
        
                    const json = JSON.parse(xhr.responseText);
        
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
                autosave_ask_before_unload: false,
                autosave_interval: '5s',
                automatic_uploads: true,
                images_upload_handler: example_image_upload_handler,
                images_upload_url: '/upload',
                toolbar: 'image bold italic underline'
            });
        </script>
        <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <textarea name="" id="with-image-upload"></textarea>
        </form>
    </body>
</html>