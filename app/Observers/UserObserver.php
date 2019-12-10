<?php

namespace App\Observers;

use App\Models\Portfolio;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;

class UserObserver {
    /**
     * Handle the role "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user) {
        factory(RoleUser::class)->create([
            'role_id' => $user->id === 1 ?
                Role::whereName('admin')->first()->id :
                Role::whereName('user')->first()->id,
            'user_id' => $user->id
        ]);

        factory(Portfolio::class)->create([
            'user_id' => $user->id
        ]);
    }
}
