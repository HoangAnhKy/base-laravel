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
    <h1>List Idea</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 10%;">User Post</th>
                    <th style="width: 55%;">Content</th>
                    <th style="width: 15%;">DayPost</th>
                    <th style="width: 10%"></th>
                </tr>
                </thead>
                <tbody>
                @forelse(($ideas ?? []) as $index => $idea)
                    <tr>
                        <td>{{ $index + 1 + (($_GET["page"] ?? 1) - 1) * $LIMIT }}</td>
                        <td><a href="{{ route("profile", $idea->userPost->id) }}" class="text-decoration-none text-primary">{{ $idea->userPost->name }}</a></td>
                        <td>{{ $idea->content }}</td>
                        <td>{{ $idea->created_at->toDateString() }}</td>
                        <td>
                            <a href="{{ route("show-ideas", $idea->id) }}"><i class="fa-solid fa-eye"></i></a>
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
        @if(!empty($ideas))
            <div class="card-footer bg-white border-0">
                {{ $ideas->links()  }}
            </div>
        @endif
    </div>
@endsection
