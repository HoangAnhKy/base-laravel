@extends("Layout.admin_layout")
@section("content")
    <h1>Admin Page</h1>
    <div class="row">
        <a href="{{ route("admin-dashboard.user") }}" class="col-4" style="text-decoration: none">
            @include("Admin.template.widgets", ["class_bg" => "bg-danger", "class_icon" => "fa-solid fa-user me-2","title" => "Users", "total" => $page["Users"] ])
        </a>
        <a href="{{ route("admin-dashboard.ideas") }}" class="col-4" style="text-decoration: none">
            @include("Admin.template.widgets", ["class_bg" => "bg-warning", "class_icon" => "fa-solid fa-lightbulb","title" => "Ideas", "total" => $page["Ideas"]])
        </a>
        <a href="{{ route("admin-dashboard.comment") }}" class="col-4" style="text-decoration: none">
            @include("Admin.template.widgets", ["class_bg" => "bg-success", "class_icon" => "fa-solid fa-comments","title" => "Comments", "total" => $page["Comments"]])
        </a>
    </div>
@endsection
