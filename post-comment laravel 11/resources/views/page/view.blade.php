@extends("Layout.default")
@section("content")
    @include("page.template_idea", ["idea" => $idea, "isView" => true, "isEdit" => false])
@endsection
