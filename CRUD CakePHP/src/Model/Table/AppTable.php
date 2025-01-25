<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table
{
    public function initialize(array $config): void
    {
    }

    private function _selectQuery($condition = [], $contain = [], $select = []){
        $query = $this->find();
        if (!empty($select)){
            $query->select($select);
        }

        if(!empty($contain)){
            $query->contain($contain);
        }

        if (!empty($condition)){
            $query->where($condition);
        }
        return $query;
    }

    public function selectAll($condition = [], $contain = [], $select = []){
        return $this->_selectQuery($condition, $contain, $select)->all()->toList();
    }

    public function selectOne($condition = [], $contain = [], $select = []){
        return $this->_selectQuery($condition, $contain, $select)->first();
    }

    public function selectPage($page = 1, $condition = [], $contain = [], $key_search = [], $filter = [], $select = []){
        $condition_default = [];
        if (!empty($condition)){
            $condition_default = array_merge($condition_default, $condition);
        }
        if (!empty($key_search)){
            $condition_default = array_merge($condition_default, $key_search);
        }
        if (!empty($filter)){
            $condition_default = array_merge($condition_default, $filter);
        }

        return $this->_selectQuery($condition_default, $contain, $select)->limit(LIMIT)->page($page);
    }
}
