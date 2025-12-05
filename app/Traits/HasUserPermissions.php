<?php

namespace App\Traits;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;

trait HasUserPermissions
{
    public function getModulePermissions($module = null): array
    {
        $permissions_arr = $this->getAllPermissions()->pluck('name')->toArray();
        if (! $module) {
            return array_values($permissions_arr);
        }

        return array_values(preg_grep('/'.$module.'/i', $permissions_arr));
    }

    public function getPermissions()
    {
        if (Auth::user()->role === RoleEnum::SA->value) {
            return ['read-users', 'update-users', 'read-tickets', 'update-tickets'];
        }

        return ['read-tickets', 'update-tickets'];
    }

    public function checkUserPermission(string $module, bool $checkRead = true, bool $checkUpdate = true): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Unauthorized');
        }

        // No checks needed
        if (! $checkRead && ! $checkUpdate) {
            return;
        }

        // BOTH read + update required
        if ($checkRead && $checkUpdate) {
            if (! $user->hasPermissionTo("read-{$module}") ||
                ! $user->hasPermissionTo("update-{$module}")) {
                abort(403, 'Forbidden');
            }

            return;
        }

        // Only read required
        if ($checkRead && ! $user->hasPermissionTo("read-{$module}")) {
            abort(403, 'Forbidden');
        }

        // Only update required
        if ($checkUpdate && ! $user->hasPermissionTo("update-{$module}")) {
            abort(403, 'Forbidden');
        }
    }

}
