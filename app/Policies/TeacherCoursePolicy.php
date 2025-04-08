<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\TeacherCourse;
use App\Models\User;

class TeacherCoursePolicy
{
    private $roles, $superadmin, $admin, $teacher;

    public function __construct()
    {
        $this->roles = Role::all();
        $this->superadmin = $this->roles->first()->name;
        $this->admin = $this->roles[1]->name;
        $this->teacher = $this->roles[3]->name;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->name === $this->superadmin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return in_array($user->role->name, [$this->superadmin, $this->admin, $this->teacher]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role->name, [$this->superadmin, $this->admin]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return in_array($user->role->name, [$this->superadmin, $this->admin]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return in_array($user->role->name, [$this->superadmin, $this->admin]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return in_array($user->role->name, [$this->superadmin, $this->admin]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->role->name === $this->superadmin;
    }
}
