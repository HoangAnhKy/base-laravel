@extends("Layout.default")

@section("content")
    <div class="text-center">
        <h2>Course {{ $course_detail->name_course ?? ""}}</h2>
        <p style="font-size: 23px;"><b>Teacher:</b> {{$course_detail->teacher->name_user}}</p>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name Student</th>
                    <th>Email Student</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($student))
                    @foreach($student as $key => $stn)
                        <tr>
                            <td>{{ $key + 1 + (($_GET["page"] ?? 1) - 1) * LIMIT }}</td>
                            <td>{{ $stn->name_user ?? "" }}</td>
                            <td>{{ $stn->email ?? "" }}</td>
                            <td>{{ LIST_STATUS[$stn->status ?? ACTIVE] }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        @if(!empty($student) && $student->lastPage() >= 2)
            <div class="card-footer">
                {{ $student->links()}}
            </div>
        @endif
    </div>
@endsection
