<div class="w-100">
    <div class="row mt-4 text-center">
        <div class=" col-10">
            <h5>{{ auth()->user()->name_user ?? "" }}</h5>
        </div>
        <div class="col-2 position-relative">
           <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#notificationModal">
               <i class="fa-regular fa-bell"></i>
               <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger" id="count-notification" style="left: 20px !important;">
                    {{ $count_notification ?? 0}}
                </span>
           </button>
        </div>

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
