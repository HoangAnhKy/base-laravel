<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Table extends Model
{

    public static function paginateForPage($condition = [], $list_filter = [], $list_search = [], $contain = [])
    {
        $ans = [];
        $key = null;
        if (!empty(static::$redis_key)) {
            $key = static::$redis_key . md5(json_encode($condition) . json_encode($list_filter) . json_encode($list_search) . json_encode($contain));
        }

        if (APP_CACHE && Redis::exists($key)) {
            $ans = unserialize(Redis::get($key));
        } else {
            $query = self::query()->with($contain);

            if (!empty($condition_table = static::$condition)) {
                $query->where($condition_table);
            }

            if (!empty($condition)) {
                $query->where($condition);
            }

            if (!empty($list_filter)) {
                if (!empty($list_filter["CONTAIN"])) {
                    foreach ($list_filter['CONTAIN'] as $relation => $conditions) {
                        $query->whereHas($relation, function ($q) use ($conditions) {
                            $q->where(...$conditions);
                        });
                    }
                    unset($list_filter["CONTAIN"]);
                }
                $query->where($list_filter);
            }
            if (!empty($list_search)) {
                if (!empty($list_search["AND"])) {
                    $query->where($list_search["AND"]);
                }
                if (!empty($list_search["OR"])) {
                    $list_or = $list_search["OR"];
                    $query->where(function ($q) use ($list_or) {
                        foreach ($list_or as $value) {
                            $q->orWhere(...$value);
                        }
                    });
                }
            }
            $ans = $query->paginate(LIMIT);
            if(APP_CACHE){
                Redis::set($key, serialize($ans));
            }
        }
        return $ans;
    }

    public static function selectOne($condition = [], $contain = [], $select = ["*"])
    {

        $query = self::query()->with($contain)->select($select);

        if (!empty($condition_table = static::$condition)) {
            $query->where($condition_table);
        }

        if (!empty($condition)) {
            $query->where($condition);
        }

        return $query->first();
    }

    public static function selectALL($condition = [], $contain = [], $select = [], $sort = [])
    {
        if (empty($select)){
            $select = ["*"];
        }

        $query = self::query()->with($contain)->select($select);

        if (!empty($condition_table = static::$condition)) {
            $query->where($condition_table);
        }

        if (!empty($condition)) {
            $query->where($condition);
        }

        if (!empty($sort)){
            if (gettype($sort[0]) === "array"){
                foreach ($sort as $order){
                    $query->orderBy(...$order);
                }
            }else{
                $query->orderBy(...$sort);
            }
        }

        return $query->get();
    }

    public static function saveDB($data_request = [])
    {
        try {
            if (!empty($data_request)) {
                self::clearCache(static::$redis_key);
                return self::query()->create($data_request);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return false;
    }

    public static function updateDB($condition, $data_request = [])
    {
        try {
            if (!empty($data_request)) {
                self::clearCache(static::$redis_key);
                return self::query()->where($condition)->update($data_request);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return false;
    }


    private static function clearCache($key = null)
    {
        if (APP_CACHE && !empty($key)) {

            $connection = Redis::connection("cache"); // Kết nối Redis cache
            $cursor = ""; // Bắt đầu từ con trỏ 0
            $keys = $connection->scan($cursor, ['match' => "*$key*"])[1] ?? [];

            foreach ($keys as $keyRedis){
                Redis::del(str_replace("laravel_database_", "", $keyRedis));
            }
        }
    }

    private function whereCustom($query, $condition_default)
    {
        if (!empty($condition_default)) {
            $match = $condition_default;
            $or = [];
            $contain = [];

            if (!empty($match["OR"])) {
                $or = $match["OR"];
                unset($match["OR"]);
            }

            if (!empty($match["CONTAIN"])) {
                $contain = $match["CONTAIN"];
                unset($match["CONTAIN"]);
            }

            $query->where($match)->where(function ($q) use ($or) {
                if (!empty($or)) {
                    $q->where(...array_shift($or));
                    foreach ($or as $condition) {
                        $q->orWhere(...$condition);
                    }
                }
            });

            if (!empty($contain)) {
                foreach ($contain as $table_key => $condition_table) {
                    $query->whereHas($table_key, function ($q) use ($condition_table) {
                        $this->whereCustom($q, $condition_table); // backtrack
                    });
                }
            }
        }

        return $query;
    }
}
