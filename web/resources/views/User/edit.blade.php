@extends("Layout.default")

@section("content")
    <div>
        <h1>Edit User {{ $user_edit->name_user ?? "" }}</h1>
    </div>

    <form method="POST" action="{{ route("users.update", ["user" => $user_edit->id]) }}">
        @csrf
        @method('PUT')
        <!-- Name -->
        <div class="mb-3">
            <label for="name_user" class="form-label">Name</label>
            <input type="text" class="form-control" id="name_user" name="name_user" placeholder="Enter your name" value="{{ old("name_user",  $user_edit->name_user ?? "" ) }}">
        </div>

        <!-- Birthdate -->
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old("birthdate", $user_edit->formatBirthdate ?? "" ) }}">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old("email", $user_edit->email ?? "" ) }}">
        </div>


        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </form>
@endsection

