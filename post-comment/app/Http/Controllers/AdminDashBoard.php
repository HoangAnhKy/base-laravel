<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class AdminDashBoard extends Controller
{
    public function index(){
//        Gate::denies("admin") // không được phép đúng không
//        Gate::allows("admin") // được phép không (true nếu được)
        Gate::authorize('admin');
        return view("Admin.Dashboard");
    }
}
