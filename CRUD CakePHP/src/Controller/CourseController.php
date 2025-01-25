<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;

class CourseController extends AppController
{
    public $model;
    public $paginate;

    public function initialize(): void
    {
        parent::initialize();
        $this->model = $this->fetchTable("Course");
        $this->paginate = $this->loadComponent('Paginate');
    }

    public function index()
    {
        $condition = [];
        $contain = ["Users"];
        $key_search = [];
        $search = trim($_GET["key_search"] ?? "");
        if (!empty($search)) {
            $key_search = [
                "OR" => [
                    "name like" => "%$search%"
                ]
            ];
        }
        $page = $_GET["page"] ?? 1;
        $courses = $this->model->selectPage($page,$condition, $contain, $key_search);
        $list_course = $courses->all()->toList();
        $paginate = $this->paginate->paginate($page, $courses->count(), $search);
        $this->set(compact("list_course", "paginate"));
    }

    public function create()
    {

        if ($this->request->getMethod() === "POST") {
            $data_request = $this->getRequest()->getData();
            $errors = [];
            try {
                if ($this->model->saveCourse($data_request, $errors)) {
                    return $this->redirect(BASE_URL);
                }
                if (!empty($errors))
                    throw new \Exception(current(current($errors)));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                dd($e->getMessage());
            }
        }
    }

    public function edit($id = null)
    {
        if (empty($id) || !is_numeric($id) || (!empty($id) && empty($edit = $this->model->selectOne(["id" => $id])))) {
            return $this->redirect(BASE_URL);
        }

        if ($this->getRequest()->getMethod() === "POST") {
            $data_request = $this->getRequest()->getData();
            $errors = [];
            try {
                if ($this->model->updateCourse($data_request, $edit, $errors)) {
                    return $this->redirect(BASE_URL);
                }
                if (!empty($errors))
                    throw new \Exception(current(current($errors)));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        $this->set(compact("edit"));
    }

    public function delete($id = null)
    {
        if (empty($id) || !is_numeric($id) || (!empty($id) && empty($course = $this->model->selectOne(["id" => $id])))) {
            return $this->redirect(BASE_URL);
        }

        $this->model->delete($course);
        return $this->redirect(BASE_URL);
    }
}
