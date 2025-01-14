<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewUser extends Component
{
    use WithPagination;
    public $sortDate;
    public function placeholder(){
        return view("livewire.Skeleton.plachoder-view-user");
    }

    #[Computed()]
    public function users(){
        if (!empty($this->sortDate) && $this->sortDate === "asc"){
            return User::query()->orderBy("name", "asc")->paginate(2);
        }
        return User::query()->latest()->paginate(2);
    }

    #[On("load-user")]
    public function render()
    {
        return view('livewire.view-user');
    }
}
