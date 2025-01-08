<div class="card">
    <form>
        <div class="card-header pb-0 border-0">
            <h5 class="">Search</h5>
        </div>
        <div class="card-body">
            <input placeholder="..." class="form-control w-100" type="text" id="search" name="q" value="{{ trim($_GET["q"] ?? "") }}">
            <button class="btn btn-dark mt-2"> Search</button>
        </div>
    </form>
</div>
<div class="card mt-3">
    <div class="card-header pb-0 border-0">
        <h5 class="">Who to follow</h5>
    </div>
    <div class="card-body">
        @if(!empty($topUser))
            @foreach( $topUser as $user )
                <div class="hstack gap-2 mb-3">
                    <div class="overflow-hidden">
                        <a class="h6 mb-0" href="{{ route("profile", $user->id) }}">{{ $user->name }}</a>
                        <p class="mb-0 small text-truncate">{{ $user->email }}</p>
                    </div>
                    <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="{{ route("user-follow", $user->id) }}"><i
                            class="fa-solid fa-plus"> </i></a>
                </div>
            @endforeach
        @endif

    </div>
</div>
