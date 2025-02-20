@extends("Layout.default")

@section('content')
    <h2 class="mb-4">Edit Course {{ $course->name_course ?? "" }}</h2>



    <form action="{{ route('courses.update', ["course" => $course->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name_course" class="form-label">Course Name</label>
            <input type="text" name="name_course" id="name_course" class="form-control"
                   value="{{ old('name_course', $course->name_course ?? "") }}">
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select" >
                <option value="" disabled selected>Select Teacher</option>
                @if(!empty($teachers))
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}"
                            {{ old('teacher_id', $course->teacher_id ?? "") == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name_user }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <button type="submit" class="btn btn-success form-control">Create Course</button>
    </form>
@endsection
