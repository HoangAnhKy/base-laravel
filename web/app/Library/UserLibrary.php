<?php

namespace App\Library;

use App\Models\Users;
use Illuminate\Validation\Rule;

class UserLibrary
{
    public function getFilter()
    {
        $filter = [];
        $filter["status"] = ACTIVE;
        if (isset($_GET["position_search"]) && in_array((int)$_GET["position_search"], array_keys(LIST_POSITION), true)) {
            $filter["position"] = $_GET["position_search"];
        }

        if (isset($_GET["status_search"]) && in_array((int)$_GET["status_search"], array_keys(LIST_STATUS), true)) {
            $filter["status"] = $_GET["status_search"];
        }

        return $filter;
    }

    public function getSearch(){
        $search = [];
        if (!empty($_GET["key_search"])){
            $key_search = $_GET["key_search"];
            $search["AND"] = [
            ];
            $search["OR"] = [
                ["users.name_user", "like", "%$key_search%"],
                ["users.email", "like", "%$key_search%"]
            ];
        }
        return $search;
    }

    public function delete($request, $user ){
        $request->merge([
            "user_id" => $user,
            "del_flag" => DEL,
            "status" => INACTIVE,
        ]);

        $validate = $request->validate([
            "user_id" => [Rule::exists(Users::class, "id")->where("status", ACTIVE)->where("del_flag", UNDEL)],
            "del_flag" => [Rule::in([DEL])],
            "status" => [Rule::in([INACTIVE])],
        ]);

        unset($validate["user_id"]);
        if(Users::updateDB(["id" => $user], $validate)){
            return true;
        }

        return false;
    }

    public function selectPosition($position = TEACHER){
        $condition = [
            ["position", $position],
            ["status", ACTIVE]
        ];
        $select = ["id", "name_user"];
        return Users::selectALL($condition, [], $select);
    }
}
