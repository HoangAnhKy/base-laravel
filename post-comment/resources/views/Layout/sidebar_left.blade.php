<div class="card overflow-hidden">
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            @can("admin")
                <li class="nav-item">
                    <a class="nav-link  {{ Route::is("admin-dashboard.index") ? "text-white bg-primary rounded" : "" }}"
                       href="{{ route("admin-dashboard.index") }}">
                        <span>Admin Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Route::is("admin-dashboard.user") ? "text-white bg-primary rounded" : "" }}"
                       href="{{ route("admin-dashboard.user") }}">
                        <span>Users</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Route::is("admin-dashboard.ideas") ? "text-white bg-primary rounded" : "" }}"
                       href="{{ route("admin-dashboard.ideas") }}">
                        <span>Ideas</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ Route::is("admin-dashboard.comment") ? "text-white bg-primary rounded" : "" }}"
                       href="{{ route("admin-dashboard.comment") }}">
                        <span>Comment</span></a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link  {{ Route::is("dashboard") ? "text-white bg-primary rounded" : "" }}"
                   href="{{ route("dashboard") }}">
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Route::is("feed") ? "text-white bg-primary rounded" : "" }}"
                   href="{{ route("feed") }}">
                    <span>Feed</span></a>
            </li>
        </ul>
    </div>
    <div class="card-body py-2">
        <p>Lang: {{ __("idea.test_localization")}}</p>
        <a class="btn btn-link btn-sm" href="{{ route("language", "en") }}">en </a>
        <a class="btn btn-link btn-sm" href="{{ route("language", "vn") }}">vn </a>
    </div>
    <div class="card-footer text-center py-2">
        <a class="btn btn-link btn-sm" href="{{ route("profile", auth()->id()) }}">View Profile </a>
    </div>
</div>
