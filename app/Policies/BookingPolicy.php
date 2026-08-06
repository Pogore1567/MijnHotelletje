<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BookingModel;

class BookingPolicy
{
    /**
     * Create a new policy instance.
     */

    public function delete(User $user, BookingModel $booking)
    {
        return $booking->user_id === $user->id || $user->is_admin;
    }
    public function create(User $user)
    {
        return true;
    }
}
