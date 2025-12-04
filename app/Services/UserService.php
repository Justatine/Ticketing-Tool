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
     * Get all user form options for dropdowns.
     */
    public function getUserCardData(): array
    {
        return [
            'total_users' => User::count(),
            'total_admins' => User::where('role', RoleEnum::SA->value)->count(),
        ];
    }

    /**
     * Get all user form options for dropdowns.
     */
    public function getUserFormOptions(): object
    {
        return (object) [
            'regions' => $this->mapEnumToOptions(RegionEnum::cases()),
            'teams' => $this->mapEnumToOptions(TeamEnum::cases()),
            'departments' => $this->mapEnumToOptions(DepartmentEnum::cases()),
            'roles' => $this->mapEnumToOptions(RoleEnum::cases()),
        ];
    }

    public function getPaginatedUsers($perPage)
    {
        $user_list = User::latest()
            ->paginate($perPage)
            ->withQueryString();

        return $user_list;
    }

    /**
     * Map enum cases to dropdown options.
     */
    private function mapEnumToOptions(array $cases): array
    {
        return collect($cases)->map(fn($val) => [
            'value' => $val->value,
            'label' => $val->label(),
        ])->toArray();
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
