<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class CourseTable extends AppTable
{
    public function initialize(array $config): void
    {
        $this->setTable("courses");
        $this->hasMany("Users",[
            'foreignKey' => "course_id"
        ])->setConditions(["Users.status" => 1]);
    }

    public function saveCourse($data_request = null, &$errors = []){
        if (!empty($data_request)){
            $new_entity = $this->newEntity($data_request);
            $errors = $new_entity->getErrors();
            if (!empty($errors)){
                return false;
            }
            if (!$this->save($new_entity)) {
                $errors = $new_entity->getErrors();
                return false;
            }
            return true;
        }
        return false;
    }

    public function updateCourse($data_request = null, $data_edit = [], &$errors = []){
        if (!empty($data_request) && !empty($data_edit)){
            $new_entity = $this->patchEntity($data_edit, $data_request);
            $errors = $new_entity->getErrors();
            if (!empty($errors)){
                return false;
            }
            if (!$this->save($new_entity)) {
                $errors = $new_entity->getErrors();
                return false;
            }
            return true;
        }
        return false;
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->requirePresence('name', 'create', 'Name is required.')
            ->notEmptyString("name", "Name not null")
            ->maxLength('name', 255, 'Name cannot be longer than 255 characters.');
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(
            ['name'], // Field to check
            'This course name already exists. Please use a different name.'
        ));
        return $rules;
    }
}
