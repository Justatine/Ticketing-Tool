<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Enums\TicketStatusEnum;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tickets $ticket): bool
    {
        // admin access
        if ($user->role === RoleEnum::SA) {
            return true;
        }

        // created the ticket
        if ($ticket->reporter_id === $user->id) {
            return true;
        }

        // assigned to resolve it
        if ($ticket->assignee_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tickets $ticket): bool
    {
        if ($ticket->status === TicketStatusEnum::CLOSED->value) {
            return false;
        }

        if ($user->role === RoleEnum::SA) {
            return true;
        }

        // created the ticket
        // if ($ticket->reporter_id === $user->id) {
        //     return true;
        // }

        // assigned to resolve it
        if ($ticket->assignee_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tickets $tickets): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tickets $tickets): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tickets $tickets): bool
    {
        return false;
    }
}
