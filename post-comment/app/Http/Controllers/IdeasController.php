<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateIdeas;
use App\Models\Ideas;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class IdeasController extends Controller
{
    public function index()
    {
        $query = Ideas::query()->with(["comments.userComment.profile" => function ($q) {
            return $q->orderBy("created_at", "DESC");
        }, "userPost.profile"])->withCount(["likes"]);

        $key_search = trim($_GET["q"] ?? "");

        if (!empty($key_search)) {
            $query->where([["content", 'like', "%$key_search%"]]);
        }

        $ideas = $query
            ->orderBy("created_at", "DESC")
            ->paginate(2);

        $currentUserId = auth()->id(); // Lấy user_id hiện tại
        foreach ($ideas as $idea) {
            $idea->is_liked = $idea->isLikedBy($currentUserId); // Gọi phương thức kiểm tra
        }
        return view("page.index", compact("ideas"));
    }

    public function save(ValidateIdeas $req)
    {
        Gate::authorize("create", Ideas::class);
        if ($req->isMethod("POST") && Ideas::query()->create($req->validated())) {
            return redirect()->back()->with("success", "Idea created Successfully");
        }
    }

    public function update(ValidateIdeas $req, $idea = null)
    {
        $res = [
            "status" => "error",
            "msg" => "Delete Ideas fail",
        ];

        Gate::authorize("update", Ideas::query()->find($idea));
        try {
            if ($req->isMethod("PUT") && !empty($idea) && is_numeric($idea)) {
                $idea = Ideas::query()->where("id", $idea)->firstOrFail();
                if (auth()->id() !== $idea->user_id){
                    $res["msg"] = "permission define";
                }else if ($idea->update($req->validated())) {
                    $res = [
                        "status" => "success",
                        "msg" => "Idea update Successfully",
                    ];
                    return redirect()->route("show-ideas", $idea->id)->with($res["status"], $res["msg"]);
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $res["msg"] = $e->getMessage();
        }
        return redirect()->back()->with($res["status"], $res["msg"]);

    }

    public function show(Ideas $idea)
    {
        if (!empty($idea)) {
            $idea->load(["comments.userComment" => function ($q) {
                return $q->orderBy("created_at", "DESC");
            }, "userPost"]);
            return view("page.view", compact("idea"));
        }
    }

    public function edit(Ideas $idea)
    {
        if (!empty($idea)) {
            if (auth()->id() !== $idea->user_id){
                return redirect()->back()->with("error", "permission define");
            }
            return view("page.edit", compact("idea"));
        }
    }

    public function delete($id = null)
    {
        $res = [
            "status" => "error",
            "msg" => "Delete Ideas fail",
        ];
        try {
            if (!empty($id) && is_numeric($id)) {
                $idea = Ideas::query()->where("id", $id)->firstOrFail();
                if (auth()->id() !== $idea->user_id){
                    $res["msg"] = "permission define";
                }else if ($idea->delete()) {
                    $res = [
                        "status" => "success",
                        "msg" => "Delete Ideas Successfully",
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $res["msg"] = "Can not find this idea";
        }
        return redirect()->back()->with($res["status"], $res["msg"]);
    }
}
