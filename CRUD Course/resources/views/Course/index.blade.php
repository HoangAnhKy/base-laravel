@extends("Layout.default")

@section("content")
    <div>
        <h1>Course</h1>
    </div>

    <div class="row">
        <div class="col-6">
            @if( isset(auth()->user()->position) && in_array(auth()->user()->position, [TEACHER], false))
                <a href="{{ route("courses.create") }}" class="btn-primary btn">Add Course <i
                        class="fa-solid fa-plus"></i></a>
            @endif
        </div>
        <div class="col-6">
            <form class="row" id="form-search-course">
                <div class="offset-3 col-4">
                    <select class="form-select" name="teacher_search" id="teacher_search">
                        <option value="-1"
                                @if(!isset($_GET["teacher_search"]) ||$_GET["teacher_search"] === "-1" ) disabled
                                selected @endif>select Teacher
                        </option>
                        @if(!empty($teachers))
                            @foreach( $teachers as $teacher)
                                <option value="{{$teacher->id}}"
                                        @if(isset($_GET["teacher_search"]) && (int)$_GET["teacher_search"] === $teacher->id) selected @endif >
                                    {{ $teacher->name_user }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class=" col-4">
                    <input class="form-control" name="key_search" id="search" placeholder="search..."
                           value="{{ old("key_search", $_GET['key_search'] ?? "") }}">
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
                <th>Name Course</th>
                <th>Teacher</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @if(!empty($courses))
                @foreach($courses as  $key => $course)
                    <tr>
                        <td>{{ $key + 1 + ((($_GET["page"] ?? 1) - 1) * LIMIT) }}</td>
                        <td><a class="text-decoration-none"
                               href="{{ route("courses.view-detail", ["course" => $course->id]) }}">{{ $course->name_course }}</a>
                        </td>
                        <td>{{ $course->teacher->name_user }}</td>
                        <td>{{ LIST_STATUS[$course->status ?? ACTIVE] }}</td>
                        <td>
                            @if( isset(auth()->user()->position) && in_array(auth()->user()->position, [TEACHER], false))
                                <a href=" {{route("courses.edit", ["course" => $course->id])}}" class="text-primary"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a href=" {{route("courses.delete", ["course" => $course->id])}}"
                                   class="text-danger mx-2"><i
                                        class="fa-regular fa-trash-can"></i></a>
                                <a data-bs-toggle="modal" data-bs-target="#register-student"
                                   data-name_course="{{$course->name_course ?? ""}}" data-course_id="{{ $course->id }}"><i
                                        class="fa-solid fa-user-plus text-primary"></i></a>
                            @elseif(isset(auth()->user()->position) && in_array(auth()->user()->position, [STUDENT], false))
                                <a href=" {{route("courses.register", ["course" => $course->id])}}"
                                   title="register course" class="text-primary mx-2"><i
                                        class="fa-solid fa-user-plus"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div id="register-student" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-register-student" method="post" action="{{ route("courses.register", ["course" => "-1"]) }}" data-course_id="-1">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="title-modal">Register Course For Student</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <select class="form-select" name="student_id" id="student_id">
                            <option value="-1" disabled selected>Select Student</option>
                            @if(!empty($students))
                                @foreach( $students as $student)
                                    <option value="{{$student->id}}">
                                        {{ $student->name_user }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script>
        $(document).ready(function () {
            function handleSearchForm() {
                $("#form-search-course").submit();
            }

            $("#teacher_search").change(handleSearchForm)

            $("#register-student").on("show.bs.modal", function (e) {
                let btn_parent = $(e.relatedTarget);
                let name_course = btn_parent.data("name_course");
                let id_course = btn_parent.data("course_id");
                let action_form = $(this).find("form").attr("action");

                if (id_course !== undefined) {
                    action_form = action_form.replace("-1", id_course);
                    $(this).find("form").attr("action", action_form);
                    $(this).find("form").attr("data-course_id", id_course);
                }


                $("#title-modal").text(`Register ${name_course} For Student`);
                $("#student_id").val("-1");
            });

            $.validator.addMethod("unique_student", function (value, element, param) {
                let isValid = false;
                $.ajax({
                    type: "get",
                    url: "{{ route("courses.check-student") }}",
                    data: {
                        student_id: value,
                        course_id: $("#form-register-student").data("course_id")
                    },
                    dataType: "json",
                    async: false,
                    success: function (response) {
                        isValid = response.status;
                    }
                });
                return isValid;
            }, "This student ID already exists.")

            $("#form-register-student").validate({
                rules: {
                    student_id: {
                        required: true,
                        // unique_student: true
                        remote: {
                            url: "{{ route('courses.check-student') }}", // Route kiểm tra student ID
                            type: "GET",
                            data: {
                                course_id: function () {
                                    return $("#form-register-student").data("course_id"); // Truyền course_id vào request
                                }
                            },
                            dataType: "json"
                        }
                    }
                },
                messages: {
                    student_id: {
                        required: "Please enter a student ID",
                        remote: "This student ID already exists."
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

