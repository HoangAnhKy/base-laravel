@extends("Layout.default")
@section("content")
    @include("page.postIdea")
    <hr>
    @foreach( $ideas as $key_idea => $idea)
        @include("page.template_idea", ["idea" => $idea, "isView" => false])
    @endforeach
    @if( !empty($ideas))
        {{ $ideas->withQueryString()->links() }}
    @endif
@endsection
