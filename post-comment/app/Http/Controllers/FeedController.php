<?php

namespace App\Http\Controllers;

use App\Models\Ideas;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $follower = $user->following()->pluck("user_id");

        $query = Ideas::query()->with(["comments.userComment.profile" => function ($q) {
            return $q->orderBy("created_at", "DESC");
        }, "userPost.profile"])->withCount(["likes"])->whereIn("ideas.user_id", $follower);

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
}
