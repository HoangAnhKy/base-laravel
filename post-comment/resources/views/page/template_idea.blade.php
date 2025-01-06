<div class="mt-3">
    <div class="card">
        <div class="px-3 pt-4 pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img style="width:50px;  height: 50px;" class="me-2 avatar-sm rounded-circle"
                         src="{{  $idea->userPost->profile->ViewImg ?? "https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" }}"
                         alt="{{ $idea->userPost->name }}">
                    <div>
                        <h5 class="card-title mb-0"><a
                                href="{{ route("profile", $idea->userPost->id) }}"> {{ $idea->userPost->name }}
                            </a></h5>
                    </div>
                </div>
                @if( !$isView )
                    <div>
                        <div class="row">

                            @can("update", $idea)
                                <a href="{{ route("show-ideas", $idea->id) }}" class="col-4"><i
                                        class="fa-solid fa-eye"></i></a>
                                <a href="{{ route("edit-ideas", $idea->id) }}" class="col-4"><i
                                        class="fa-solid fa-arrows-rotate"></i></a>
                                <form class="col-4" action="{{ route("delete-ideas", ["id" => $idea->id]) }}"
                                      method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"> X</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <p class="fs-6 fw-light text-muted">
                @if( isset($isEdit) && $isEdit)
                    <textarea class="form-control @if( $errors->get("content")) is-invalid @endif" id="idea"
                              name="content" rows="3">{{ old("content", $idea->content ?? "") }}</textarea>
                    @error('content')
                    <span id="validationFeedback" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                @else
                    {{$idea->content}}
                @endif
            </p>
            <div class="d-flex justify-content-between">
                <div>
                    @auth()
                        @if( $idea->is_liked ?? false)
                            <div class="mt-3">
                                <form action="{{ route("user-unlike", $idea->id) }}" method="post">
                                    @csrf
                                    <button class="border-0 bg-white"><span
                                            class="fas fa-heart me-1"></span> {{ $idea->likes_count ?? 0 }}</button>
                                </form>
                            </div>
                        @else
                            <div class="mt-3">
                                <form action="{{ route("user-like", $idea->id) }}" method="post">
                                    @csrf
                                    <button class="border-0 bg-white"><span
                                            class="far fa-heart me-1"></span> {{ $idea->likes_count ?? 0 }}</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                <div>
                    <span class="fs-6 fw-light text-muted">
                        <span class="fas fa-clock"> </span> {{ $idea->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            @if( isset($isEdit) && $isEdit)
                <div class="text-end m-2">
                    <button class="btn btn-dark">Update</button>
                </div>
            @endif
            <hr/>
            @include("Comment.commentIdea", ["idea" => $idea])
        </div>
    </div>
</div>
