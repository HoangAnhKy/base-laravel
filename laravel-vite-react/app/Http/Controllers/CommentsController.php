<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentsController extends Controller
{
    public function comment(Request $request){
        try {
            $validated = $request->validate([
                "content_comment" => "bail|required|string",
                "user_comment" => "bail|required|exists:App\Models\User,id",
                "idea_id" => "bail|required|exists:App\Models\Ideas,id",
            ]);

            if (Comments::query()->create($validated)){
                return response()->json([
                    'message' => "Comment success"
                ]);
            }
            throw new \Exception("Cannot save comment");

        }catch (ValidationException $e){
            $error = current(current($e->errors()));

            return response()->json([
                "error" => $e->errors(),
                'message' => "Comment failed: " . $error
            ], 422);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Comment failed: ' . $e->getMessage()
            ], 400);
        }
    }
}
