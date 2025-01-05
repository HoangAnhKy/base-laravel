<?php

namespace App\Http\Controllers;


use App\Mail\wellcomeEmail;
use App\Models\Follower;
use App\Models\Likes;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function formRegister()
    {
        return view("Users.register");
    }

    public function formLogin()
    {
        if (auth()->check()) {
            return redirect()->route("dashboard");
        }

        return view("Users.login");
    }

    public function save(Request $req)
    {
        try {

            if ($req->isMethod("POST")) {
                // validate
                $validated = $req->validate([
                    "name" => "required|string|min:5|max:20|unique:users,name",
                    "email" => "required|email|unique:users,email",
                    "password" => "required|min:6|confirmed:confirm-password",
                ]);

                if (!empty($validated) && $user = User::query()->create($validated)) {
//                    Mail::to($user->email)->send(new wellcomeEmail($user));
                    return redirect()->route("dashboard")->with("success", "Register Accound success");
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route("register")->with("error", "Register Accound fail");
    }

    public function handleLogin(Request $req)
    {
        try {

            if ($req->isMethod("POST")) {
                // validate
                $validated = $req->validate([
                    "email" => "required|email",
                    "password" => "required|min:6",
                ]);

                if (auth()->attempt($validated)) {
                    request()->session()->regenerate(); // tạo phiên token 1 lần
                    return redirect()->route("dashboard")->with("success", "Login Accound success");
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return redirect()->route("login")->with("error", "Login Accound Fail, can not find this accound");
    }
    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            request()->session()->invalidate(); // Hủy bỏ session hiện tại
            request()->session()->regenerateToken(); // Tạo CSRF token mới
            return redirect()->route("dashboard")->with("success", "Login Accound success");
        }
    }

    public function profile($user)
    {
        $user = User::query()
            ->with(["profile", "idea.userPost.profile", "idea.comments.userComment.profile"])
            ->withCount(['comment', 'idea', 'follower'])
            ->where(["id" => $user])->firstOrFail();

            $unfollow = !empty($user->follower()->where("user_follow", auth()->id())->get()->toArray());

            return view("Users.profile", compact("user", "unfollow"));
    }

    public function editProfile(User $user)
    {
        $edit = true;
        return view("Users.profile", compact("user", "edit"));
    }
    public function saveEditProfile(Request $req, $user_id)
    {
        $rep = [
            "status" => "error",
            "msg" => "Can not update user profile"
        ];

        if ($req->isMethod("PUT") && isset($user_id)) {
            $req->merge(["user_id" => $user_id]);
            $validated = $req->validate([
                "user_id" => "required|exists:users,id",
                "name" => [
                    "required",
                    Rule::unique('users', 'name')->ignore($user_id)
                ],
                "content" => "required"
            ]);

            DB::beginTransaction();
            try {

                User::query()->where(["id" => $user_id])->update(["name" => $validated["name"]]);
                unset($validated["name"]);

                $file = $req->file("url_img") ?? null;
                if (!empty($file)) {
                    $path = Storage::disk('public')->putFile('avatars', $file);
                    $validated["url_img"] = "storage/" . $path;
                }

                Profile::query()->updateOrCreate(
                    ["user_id" => $user_id],
                    $validated
                );

                $rep = [
                    "status" => "success",
                    "msg" => "update user profile success"
                ];

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }

        if (!empty($user_id))
            return redirect()->route("profile", $user_id)->with($rep["status"], $rep["msg"]);
        return redirect()->back()->with($rep["status"], $rep["msg"]);
    }
    public function follow(Request $request, User $user)
    {
        $rep = [
            "status" => "error",
            "msg" => "Can not follow user"
        ];

        if ($request->isMethod("POST") && !empty($user)) {

            $data_save = [
                "user_id" => $user->id,
                "user_follow" => auth()->id(),
            ];

            try {
                $request->merge($data_save);

                $validate = $request->validate([
                    "user_id" => "required|exists:users,id",
                    "user_follow" => [
                        "required",
                        Rule::exists(User::class, "id"),
                        Rule::unique(Follower::class, "user_follow")->where(function ($query) use ($user) {
                            $query->where("user_id", $user->id);
                        }),
                    ],
                ]);

                Follower::query()->create($validate);

                $rep = [
                    "status" => "success",
                    "msg" => "follow user success"
                ];
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $rep["msg"] = $e->getMessage();
            }
        }
        return redirect()->back()->with($rep["status"], $rep["msg"]);
    }

    public function unfollow(Request $request, $user)
    {
        $rep = [
            "status" => "error",
            "msg" => "Can not follow user"
        ];


        if ($request->isMethod("POST") && !empty($user)) {
            try {
                $request->merge(["user_id" => $user]);

                $validate = $request->validate([
                    "user_id" => [
                        Rule::exists(User::class, "id"),
                        Rule::exists(Follower::class, "user_id")->where(function ($query) {
                            $query->where("user_follow", auth()->id());
                        }),
                    ],
                ]);

                Follower::query()->where([
                    "user_id" => $user,
                    "user_follow" => auth()->id(),
                ])->delete();

                $rep = [
                    "status" => "success",
                    "msg" => "unfollow user success"
                ];
            } catch (\Exception $e) {
                $rep["msg"] = $e->getMessage();
                Log::error($e->getMessage());
            }
        }
        return redirect()->back()->with($rep["status"], $rep["msg"]);
    }

    public function like(Request $request, $idea_id)
    {
        $rep = [
            "status" => "error",
            "msg" => "Can not like user"
        ];

        if ($request->isMethod("POST") && !empty($idea_id)) {

            $data_save = [
                "idea_id" => $idea_id,
                "user_like" => auth()->id(),
            ];

            try {
                $request->merge($data_save);

                $validate = $request->validate([
                    "idea_id" => "required|exists:ideas,id",
                    "user_like" => [
                        "required",
                        Rule::exists(User::class, "id"),
                        Rule::unique(Likes::class, "user_like")->where(function ($query) use ($idea_id) {
                            $query->where("idea_id", $idea_id);
                        }),
                    ],
                ]);

                Likes::query()->create($validate);

                $rep = [
                    "status" => "success",
                    "msg" => "Like idea success"
                ];
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $rep["msg"] = $e->getMessage();
            }
        }
        return redirect()->back()->with($rep["status"], $rep["msg"]);
    }

    public function unlike(Request $request, $idea_id)
    {
        $rep = [
            "status" => "error",
            "msg" => "Can not unlike user"
        ];

        if ($request->isMethod("POST") && !empty($idea_id)) {
            try {
                $request->merge(["idea_id" => $idea_id]);

                $validate = $request->validate([
                    "idea_id" => "required|exists:ideas,id"
                ]);

                Likes::query()->where([
                    "idea_id" => $idea_id,
                    "user_like" => auth()->id(),
                ])->delete();

                $rep = [
                    "status" => "success",
                    "msg" => "Unlike idea success"
                ];
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $rep["msg"] = $e->getMessage();
            }
        }
        return redirect()->back()->with($rep["status"], $rep["msg"]);
    }
}
