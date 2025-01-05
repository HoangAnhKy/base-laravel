@extends("Layout.default")

@section("content")
    <div>
        <h1>User</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <a href="{{ route("users.create") }}" class="btn-primary btn">Add User <i class="fa-solid fa-plus"></i></a>
        </div>
        <div class="col-6">
            <form class="row" id="form-search-user">
                <div class="col-4">
                    <select class="form-select" name="position_search" id="position_search">
                        <option value="-1">ALL POSITION</option>
                        @foreach( LIST_POSITION as $k_position => $v_position)
                            <option value="{{$k_position}}"
                                    @if(isset($_GET["position_search"]) && (int)$_GET["position_search"] === $k_position) selected @endif>{{ $v_position }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <select class="form-select" name="status_search" id="status_search">
                        @foreach( LIST_STATUS as $k_status => $v_status)
                            <option value="{{$k_status}}"
                                @if(isset($_GET["status_search"]) && (int)$_GET["status_search"] === $k_status) selected
                                @elseif( !isset($_GET["status_search"]) && $k_status === ACTIVE) selected @endif
                            >{{ $v_status }}</option>
                        @endforeach
                    </select></div>
                <div class="col-4">
                    <input class="form-control" name="key_search" id="search" placeholder="search name or email"  value="{{ old("key_search", $_GET['key_search'] ?? "") }}">
                </div>
                <button class="btn btn-success col-1"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

    </div>

    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @if(!empty($users))
                @foreach($users as  $key => $user)
                    <tr>
                        <td>{{ $key + 1 + ((($_GET["page"] ?? 1) - 1) * LIMIT) }}</td>
                        <td>{{ $user->name_user }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ LIST_POSITION[$user->position ?? 0] }}</td>
                        <td>{{ LIST_STATUS[$user->status ?? 0] }}</td>
                        <td>
                            <a href=" {{route("users.edit", ["user" => $user->id])}}" class="text-primary"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a href=" {{route("users.delete", ["user" => $user->id])}}" class="text-danger mx-2"><i
                                    class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection

@push("js")
    <script>
        $(document).ready(function () {
            function handleSearchForm() {
                $("#form-search-user").submit();
            }

            $("#position_search").change(handleSearchForm)
            $("#status_search").change(handleSearchForm)
        });
    </script>
@endpush
