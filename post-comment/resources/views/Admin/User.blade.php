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
    <h1>List User</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Join day</th>
                </tr>
                </thead>
                <tbody>
                @forelse(($users ?? []) as $index => $user)
                    <tr>
                        <td>{{ $index + 1 + (($_GET["page"] ?? 1) - 1) * $LIMIT }}</td>
                        <td><a href="{{ route("profile", $user->id) }}" class="text-decoration-none text-primary">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->toDateString() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No data</td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
        @if(!empty($users))
            <div class="card-footer bg-white border-0">
                {{ $users->links()  }}
            </div>
        @endif
    </div>
@endsection
