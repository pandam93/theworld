<form method="POST" action="{{ route('threads.replies.store', [$thread]) }}"
enctype="multipart/form-data">
@csrf
<div class="form-group row">
    <label for="inputTitle" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
        <input class="form-control" type="text" name="reply_user"
            placeholder="{{ Auth::user()->name ?? 'Anonymous' }}" readonly>
    </div>
</div>
<div class="form-group row">
    <label for="TextareaText"
        class="col-sm-2 col-form-label my-auto">Text</label>
    <div class="col-sm-10">
        <textarea class="form-control @error('reply_text') is-invalid @enderror" id="TextareaText" rows="5"
            name="reply_text">{{ old('reply_text') ?? '' }}</textarea>
            <div class="invalid-feedback text-left">
            @error('reply_text')
            · {{ $message }}
            @enderror
            </div>
    </div>
</div>
<div class="form-group row">
    <label for="FileImage" class="col-sm-2 col-form-label">File</label>
    <div class="col-sm-10">
        <input type="file" class="form-control-file @error('reply_image') is-invalid @enderror" id="FileImage"
            name="reply_image">
            <div class="invalid-feedback text-left">
                @error('reply_image')
                · {{ $message }}
                @enderror
                </div>
    </div>
</div>
<div class="form-group row">
    <label for="InputUrl" class="col-sm-2 col-form-label">URL</label>
    <div class="col-sm-10">
        <input type="url" class="form-control @error('reply_url') is-invalid @enderror" id="InputUrl" name="reply_url"
            placeholder="url">
            <div class="invalid-feedback text-left">
            @error('reply_url')
            · {{ $message }}
            @enderror
            </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">Post</button>
</form>