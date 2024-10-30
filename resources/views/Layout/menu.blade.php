<div class="w-100">
    <div class="mt-4 text-center">
        <h5>{{ auth()->user()->name_user ?? "" }}</h5>
    </div>

    <hr/>
    <div>
        <ul class="list-group-custom">
            <a href="{{ route("courses.index") }}" class="text-decoration-none text-white">
                <li class="list-group-item-custom @if( class_basename(Route::current()->controller) === "CoursesController") bg-secondary @endif">
                    Course
                </li>
            </a>
            @if( isset(auth()->user()->position) && in_array(auth()->user()->position, [TEACHER], false))
                <a href="{{ route("users.index") }}" class="text-decoration-none text-white">
                    <li class="list-group-item-custom @if( class_basename(Route::current()->controller) === "UsersController") bg-secondary @endif">
                        User
                    </li>
                </a>
            @endif

        </ul>
    </div>

    <div class=" text-center py-3">
        <a href="{{ route("users.logout") }}" class="text-decoration-none text-white">Đăng xuất</a>
    </div>

</div>
