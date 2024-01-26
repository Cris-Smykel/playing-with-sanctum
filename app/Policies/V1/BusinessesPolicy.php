<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Models\V1\Businesses;
use Illuminate\Auth\Access\Response;

class BusinessesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::deny('You do not have permission to view all businesses.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Businesses $businesses): Response
    {
        return $user->id === $businesses->id
            ? Response::allow()
            : Response::deny('You do not have permission to view this business.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::deny('You do not have permission to create new businesses.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Businesses $businesses): Response
    {
        return $user->id === $businesses->id
            ? Response::allow()
            : Response::deny('You do not have permission to update this business.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Businesses $businesses): Response
    {
        return $user->id === $businesses->id
            ? Response::allow()
            : Response::deny('You do not have permission to delete this business.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Businesses $businesses): Response
    {
        // If you don't support soft deletes, you can remove or deny this action.
        return Response::deny('You do not have permission to restore this business.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Businesses $businesses): Response
    {
        // If you don't support soft deletes, you can remove or deny this action.
        return Response::deny('You do not have permission to permanently delete this business.');
    }
}
