<form action="{{ route("post-comments", $idea->id) }}" method="post">
    @csrf
    <div class="mb-3">
        <textarea class="fs-6 form-control @error('content_comment_' . $idea->id) is-invalid @enderror" rows="1" name="content_comment_{{$idea->id}}">{{ old("content_comment_".$idea->id, "") }}</textarea>
        @error('content_comment_' . $idea->id)
        <span id="validationFeedback" class="invalid-feedback">{{ $message }}</span>
        @enderror

    </div>
    <div>
        <button class="btn btn-primary btn-sm"> Post Comment</button>
    </div>
</form>
