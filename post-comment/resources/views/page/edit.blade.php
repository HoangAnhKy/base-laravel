@extends("Layout.default")
@section("content")
    <form action="{{ route("update-ideas",$idea->id) }}" method="post">
        @csrf
        @method('PUT')
        @include("page.template_idea", ["idea" => $idea, "isView" => true, "isEdit" => true])
    </form>

@endsection
