@extends("Layout.default")
@section("content")
    <h1>Profile</h1>
    <div class="card">
        <div class="px-3 pt-4 pb-2">
            @if( $edit ?? false)
                <form action="{{  route("user-save-edit", $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            @endif
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img style="width:150px; height: 150px" class="me-3 avatar-sm rounded-circle"
                             src="{{ $user->profile->ViewImg ?? "https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" }}" alt="{{ $user->name }} Avatar">
                        <div>
                            @if( $edit ?? false)
                                <h3 class="card-title mb-0">
                                    <input name="name" class="form-control" value="{{ $user->name }}"/>
                                    @error('name')
                                    <span id="validationFeedbackEmail" class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </h3>
                            @else
                                <h3 class="card-title mb-0">{{ $user->name }}</h3>
                            @endif
                            <span class="fs-6 text-muted">{{ $user->email }}</span>
                        </div>
                    </div>
                    @auth()
                        @if( $user->id === auth()->id())

                            @if( $edit ?? false)
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-sm"> Save</button>
                                </div>
                            @else
                                <div class="mt-3">
                                    <a class="btn btn-primary btn-sm" href="{{ route("user-edit", $user->id) }}">
                                        Edit</a>
                                </div>
                            @endif
                        @endif
                    @endauth
                </div>
                <div class="px-2 mt-4">
                    @if( $edit ?? false)

                        <input type="file" class="form-control" name="url_img" />

                        <h5 class="fs-5"> About : </h5>
                        <textarea class="form-control" name="content">{{ $user->profile->content ?? "" }}</textarea>
                        @error('content')
                        <span id="validationFeedbackEmail" class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    @else
                        <h5 class="fs-5"> About : </h5>
                        <p class="fs-6 fw-light">
                            {{ $user->profile->content ?? "null" }}
                        </p>
                    @endif
                        <div class="d-flex justify-content-start">
                            <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-user me-1">
                                </span> {{ $user->follower_count }} Followers </a>
                            <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-brain me-1">
                                </span> {{ $user->idea_count }} </a>
                            <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-comment me-1">
                                </span> {{ $user->comment_count }} </a>
                        </div>
                    @auth()
                        @if( $user->id !== auth()->id() )
                            @if( $unfollow ?? false)
                                <div class="mt-3">
                                    <form action="{{ route("user-unfollow", $user->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-sm"> Unfollow</button>
                                    </form>
                                </div>
                            @else

                                <div class="mt-3">
                                    <form action="{{ route("user-follow", $user->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-sm"> Follow</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    @endauth
                </div>
            @if( $edit ?? false)
                </form>
            @endif
        </div>
    </div>
    <hr>
    @foreach( $user->idea as $key_idea => $idea)
        @include("page.template_idea", ["idea" => $idea, "isView" => false])
    @endforeach
@endsection
