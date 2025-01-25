<?php

namespace App\Http\Controllers;

use App\Models\Ideas;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IdeasController extends Controller
{
    public function postIdea(Request $request)
    {
        try {
            $validated = $request->validate([
                "content" => "bail|required|string",
                "user_post" => "bail|required|exists:App\Models\User,id",
            ]);

            if (Ideas::query()->create($validated)) {
                return response()->json([
                    'message' => "Post Idea success"
                ]);
            }
            throw new \Exception("Cannot save idea");

        } catch (ValidationException $e) {
            $error = current(current($e->errors()));

            return response()->json([
                "error" => $e->errors(),
                'message' => "Post Idea failed: " . $error
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post Idea failed: ' . $e->getMessage()
            ], 400);
        }
    }

    public function getIdeas()
    {
        try {
            $key_search = $_GET["key_search"] ?? "";
            $query = Ideas::query()->with(["user", "comment.user:name,id"]);
            if (!empty($key_search)) {
                $query->where("content", "like", "%$key_search%");
            }
            $ideas = $query->latest()->paginate(1);
            return response()->json([
                'ideas' => $ideas->getCollection(),
                'pagination' => $ideas->appends(['key_search' => $key_search])->linkCollection()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Get idea fail: ' . $e->getMessage()
            ], 400);
        }
    }
}
