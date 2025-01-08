<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Ideas;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class AdminDashBoard extends Controller
{
    protected $LIMIT = 5;

    public function __construct()
    {
//        Gate::denies("admin") // không được phép đúng không
//        Gate::allows("admin") // được phép không (true nếu được)
//        Gate::authorize('admin'); // Ném ngoại lệ khi không có quyền
        View::share("LIMIT", $this->LIMIT);
    }

    public function index()
    {
        $page = [
            "Users" => User::query()->count(),
            "Ideas" => Ideas::query()->count(),
            "Comments" => Comments::query()->count()
        ];
        return view("Admin.Dashboard", compact("page"));
    }

    public function user()
    {
        $users = User::query()->latest()->paginate($this->LIMIT);
        return view("Admin.User", compact("users"));
    }

    public function ideas()
    {
        $ideas = Ideas::query()->with(["userPost"])->latest()->paginate($this->LIMIT);
        return view("Admin.Idea", compact("ideas"));
    }

    public function comments()
    {
        $comments = Comments::query()->with(["userComment", "idea"]);
        if (!empty($_GET["sort"])){
            $comments->orderBy("idea_id", "DESC");
        }
        $comments = $comments->latest()->paginate($this->LIMIT);
        return view("Admin.Comment", compact("comments"));
    }
}
