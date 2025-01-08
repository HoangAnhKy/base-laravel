@extends("Layout.admin_layout")
@push("css")
    <style>
        a.text-decoration-none {
            text-decoration: none !important; /* Không gạch chân mặc định */
        }

        a.text-decoration-none:hover {
            text-decoration: underline !important; /* Gạch chân khi hover */
        }
    </style>
@endpush

@section("content")
    <h1>List Comment</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">User Comment</th>
                    <th style="width: 30%;">
                        <a class="text-decoration-none" title="sort-by-content" href="@if(empty($_GET["sort"])){{ route("admin-dashboard.comment", ["sort" => "content-idea"]) }}
                                                              @else {{ route("admin-dashboard.comment") }} @endif">
                            Content Idea</a>
                    </th>
                    <th style="width: 35%;">Content</th>
                    <th style="width: 10%;">DayComment</th>
                    <th style="width: 5%"></th>
                </tr>
                </thead>
                <tbody>
                @forelse(($comments ?? []) as $index => $comment)
                    <tr>
                        <td>{{ $index + 1 + (($_GET["page"] ?? 1) - 1) * $LIMIT }}</td>
                        <td><a href="{{ route("profile", $comment->userComment->id) }}" title="View User"
                               class="text-decoration-none text-primary">{{ $comment->userComment->name }}</a></td>
                        <td><a href="{{ route("show-ideas", $comment->idea_id) }}" title="View Idea"
                               class="text-decoration-none text-primary">{{ $comment->idea->content }}</a></td>
                        <td>{{ $comment->content_comment }}</td>
                        <td>{{ $comment->created_at->toDateString() }}</td>
                        <td>
                            <a href="{{ route("show-ideas", $comment->id) }}"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No data</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
        @if(!empty($comments))
            <div class="card-footer bg-white border-0">
                {{ $comments->links()  }}
            </div>
        @endif
    </div>
@endsection
