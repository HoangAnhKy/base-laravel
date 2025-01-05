<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateComment;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    public function SaveComment(ValidateComment $req, $idea_id = null){
        try {
            if ($req->isMethod("POST") && Comments::query()->create($req->validated())){
                return redirect()->route("dashboard")->with("success", "comment success");
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
        return redirect()->route("dashboard")->with("error", "comment fail");
    }
}
