@auth()
    <h4> Share yours ideas </h4>
    <div class="row">
        <form action="{{ route("save-ideas") }}" method="post">
            @csrf
            <div class="mb-3">
                <textarea class="form-control @if( $errors->get("content")) is-invalid @endif" id="idea" name="content" rows="3">{{ old("content", "") }}</textarea>
                @error('content')
                <span id="validationFeedback" class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="">
                <button class="btn btn-dark"> Share</button>
            </div>
        </form>
    </div>
@endauth
@guest()
    <h4> Login Share yours ideas </h4>
@endguest
