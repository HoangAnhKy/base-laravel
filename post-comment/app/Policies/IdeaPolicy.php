<?php

namespace App\Policies;

use App\Models\Ideas;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdeaPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ideas $ideas): bool
    {
        return $user->is($ideas->userPost);
        /*
         * Kiểm tra xem người dùng hiện tại có phải là chủ sở hữu của Idea hay không.
         * $idea->userPost là một quan hệ giữa Idea và User (sử dụng Eloquent relationship). Quan hệ này thường được định nghĩa trong model Idea
         * $user->is($ideas->userPost) sử dụng phương thức is() của Eloquent để so sánh xem $user có khớp với $idea->user (người tạo ra Idea) hay không.
         * */
    }
}
