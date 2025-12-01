<?php

namespace App\Services;

use App\Enums\DepartmentEnum;
use App\Enums\RegionEnum;
use App\Enums\RoleEnum;
use App\Enums\TeamEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Store a new user.
     */
    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * Update an existing user.
     */
    public function update(User $user, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // don't overwrite password
        }

        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user): void
    {
        $user->delete();
    }

    /**
     * Get all regions for dropdown.
     */
    public function getRegions(): array
    {
        return collect(RegionEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }
    /**
     * Get all regions for dropdown.
     */
    public function getTeams(): array
    {
        return collect(TeamEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }
    /**
     * Get all departments for dropdown.
     */
    public function getDepartments(): array
    {
        return collect(DepartmentEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }

    /**
     * Get all roles for dropdown.
     */
    public function getRoles(): array
    {
        return collect(RoleEnum::cases())->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
    }
}
