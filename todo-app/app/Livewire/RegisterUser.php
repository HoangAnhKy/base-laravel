<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterUser extends Component
{
    use WithFileUploads;

    #[Rule("required|min:3|max:50")]
    public $name;
    #[Rule("required|email|min:3|max:50")]
    public $email;
    #[Rule("required|min:3")]
    public $password;

    #[Rule("nullable")]
    public $image;

    public function createUser(){
        $validate = $this->validate();

        if (!empty($this->image)){
            $validate["image"] = $this->image->store("upload", "public");
        }
        User::create($validate);
        $this->reset();
    }



    public function render()
    {
        return view('livewire.register-user');
    }
}
