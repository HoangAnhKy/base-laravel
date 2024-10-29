<?php

namespace App\Http\Controllers;

use App\Library\UserLibrary;
use App\Models\Users;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $lib_user;
    public function __construct()
    {
        $this->lib_user = new UserLibrary();
    }

    public function index()
    {
        $condition = [];

        $list_filter = $this->lib_user->getFilter();

        $list_search = $this->lib_user->getSearch();

        $users = Users::paginateForPage($condition, $list_filter, $list_search);

        return view("User.index", compact("users"));
    }

    public function create(){
        return view("User.Create");
    }

    public function edit($user = null){
        if (isset($user) &&is_numeric($user)){
            $user_edit = Users::selectOne(["id" => $user]);
            if(!empty($user_edit)){
                return view("User.edit", compact("user_edit"));
            }
        }
        return redirect()->route("users.index")->with("error", "Cannot find this user");
    }

    public function store(StoreUsersRequest $request){
        if ($request->getMethod() === POST && Users::saveDB($request->validated())){
            return redirect()->route("users.index")->with("success", "Save User Success");
        }
        return redirect()->route("users.create")->with("error", "Cannot save user");
    }

    public function update(UpdateUsersRequest $request, $user = null){
        if (isset($user) &&is_numeric($user)){
            if(Users::updateDB(["id" => $user], $request->validated())){
                return redirect()->route("users.index")->with("success", "Edit User Success");
            }
        }
        return redirect()->route("users.index")->with("error", "Cannot find this user");
    }
    public function delete(Request $request, $user = null){
        if (isset($user) &&is_numeric($user)){
            if($this->lib_user->delete($request, $user)){
                return redirect()->route("users.index")->with("success", "Delete User Success");
            }
        }
        return redirect()->route("users.index")->with("error", "Cannot find this user");
    }

    public function login(){
        return view("User.login");
    }

    public function logout(){
        \auth()->logout();
        return redirect("/");
    }

    public function handleLogin(Request $request){
        if ($request->getMethod() === POST && Auth::attempt($request->except("_token"))){
            if (Auth::user()->position === TEACHER) {
                return redirect()->route('users.index')->with("success", "login success");
            }

            if (Auth::user()->position === STUDENT) {
                return redirect()->route('courses.index')->with("success", "login success");
            }
        }
    }

}
