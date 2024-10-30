@extends("Layout.default")

@section("content")
    <div>
        <h1>User Add</h1>
    </div>

    <form method="POST" action="{{ route("users.store") }}">
        @csrf
        <!-- Name -->
        <div class="mb-3">
            <label for="name_user" class="form-label">Name</label>
            <input type="text" class="form-control" id="name_user" name="name_user" placeholder="Enter your name" value="{{ old("name_user", " ") }}">
        </div>

        <!-- Birthdate -->
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old("birthdate", " ") }}">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old("email", " ") }}">
        </div>

        <!-- Position -->
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select class="form-select" id="position" name="position" >
                <option value="" disabled selected>Select Position</option>
                @foreach( LIST_POSITION as $k_position => $v_position)
                    <option value="{{$k_position}}">{{ $v_position }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </form>
@endsection

