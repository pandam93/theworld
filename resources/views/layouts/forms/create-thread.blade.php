<form method="POST" action="{{ route('boards.threads.store', [$board]) }}"
enctype="multipart/form-data">
@csrf
<div class="form-group row">
    <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
        <input type="text" class="form-control required" id="inputPassword"
            name="title" placeholder="Your shitpost">
    </div>
</div>
<div class="form-group row">
    <label for="TextareaText"
        class="col-sm-2 col-form-label my-auto">Text</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="TextareaText" rows="5"
            name="thread_text"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="FileImage" class="col-sm-2 col-form-label">File</label>
    <div class="col-sm-10">
        <input type="file" class="form-control-file" id="FileImage"
            name="thread_image">
    </div>
</div>
<div class="form-group row">
    <label for="InputUrl" class="col-sm-2 col-form-label">URL</label>
    <div class="col-sm-10">
        <input type="url" class="form-control" id="InputUrl" name="thread_url"
            placeholder="url">
    </div>
</div>
<button type="submit" class="btn btn-primary">Post</button>
</form>