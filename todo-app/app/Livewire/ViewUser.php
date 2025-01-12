<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewUser extends Component
{
    use WithPagination;

    public function placeholder(){
        return view("livewire.Skeleton.plachoder-view-user");
    }

    #[On("load-user")]
    public function render()
    {
//        sleep(3);
        return view('livewire.view-user', [
            "users" => User::query()->latest()->paginate(2)
        ]);
    }
}
