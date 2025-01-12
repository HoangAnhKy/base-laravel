<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Rule("required|min:3|max:50")]
    public $name;
    public $checked;
    public $search;
    public $TODO_ID_EDIT;
    #[Rule("required|min:3|max:50")]
    public $todo_edit_name;

    public function createTodo(){
        $validate = $this->validateOnly("name");
        try {
            Todo::create($validate);
            $this->reset();
            $this->resetPage();
            session()->flash("success", "save todo success");
        }catch (\Exception $e){
            session()->flash("error", $e->getMessage());
        }
    }

    public function remove($id){
        try {
            $current_delete = Todo::query()->find($id);

            if (empty($current_delete)){
               return session()->flash('error', 'cannot find this value');
            }
            $current_delete->delete();
            return session()->flash('success', "remove todo {$current_delete->name} success");
        }catch (\Exception $e){
            session()->flash("error", $e->getMessage());
        }
    }

    public function toggleChecked($id){
        try {
            $current_delete = Todo::query()->find($id);

            if (empty($current_delete)){
                return session()->flash('error', 'cannot find this value');
            }
            $current_delete->completed = !$current_delete->completed;
            $current_delete->save();
        }catch (\Exception $e){
            session()->flash("error", $e->getMessage());
        }
    }

    public function edit($todoID = null){
        if (!empty($todoID)){
            $this->TODO_ID_EDIT = $todoID;
            $this->todo_edit_name = Todo::find($todoID)->name;
        }else{
            $this->reset("TODO_ID_EDIT", "todo_edit_name");
        }
    }

    public function update(){

        $this->validateOnly("todo_edit_name");

        $data = Todo::find($this->TODO_ID_EDIT);
        $data->name = $this->todo_edit_name;
        $data->save();
        $this->edit();
    }

    public function mount($q){
        $this->search = $q;
    }


    public function render()
    {
        $todos = Todo::query();

        $todos->where("name", "like", "%$this->search%");

        $todos = $todos->latest()->paginate(5);
        return view('livewire.ToDo.todo-list', compact("todos"));
    }
}
