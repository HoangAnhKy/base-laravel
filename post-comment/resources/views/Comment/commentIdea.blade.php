<div>
    @include("Comment.postComment",  ["idea" => $idea])
    <hr>
    @if( !empty($idea->comments) )
        @foreach($idea->comments as $comment)
            <div class="d-flex align-items-start">
                <img style="width:35px;  height: 35px;" class="me-2 avatar-sm rounded-circle"
                     src="{{ $comment->userComment->profile->ViewImg ?? "https://api.dicebear.com/6.x/fun-emoji/svg?seed=Luigi" }}"
                     alt="{{ $comment->userComment->name }}">
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route("profile", $comment->user_id) }}">{{ $comment->userComment->name }}
                        </a>
                        <small class="fs-6 fw-light text-muted">
                            {{ $comment->created_at->diffForHumans()  }}
                        </small>
                    </div>
                    <p class="fs-6 mt-3 fw-light">
                        {{ $comment->content_comment }}
                    </p>
                </div>
            </div>
        @endforeach
    @endif
</div>
